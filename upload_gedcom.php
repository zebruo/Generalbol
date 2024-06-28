<?php
include 'config/connexion.php'; // Assurez-vous que ce fichier contient les détails de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['gedcomFile'])) {
    $fileTmpPath = $_FILES['gedcomFile']['tmp_name'];
    $fileName = $_FILES['gedcomFile']['name'];
    $fileSize = $_FILES['gedcomFile']['size'];
    $fileType = $_FILES['gedcomFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    if ($fileExtension == 'ged') {
        $uploadFileDir = './uploaded_files/';

        // Créer le répertoire s'il n'existe pas
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        $dest_path = $uploadFileDir . $fileName;

        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            processGedcomFile($dest_path, $conn);
            echo "Fichier téléchargé avec succès.";
        } else {
            echo "Il y a eu une erreur lors du téléchargement du fichier.";
        }
    } else {
        echo "Veuillez télécharger un fichier GEDCOM valide.";
    }
}

function processGedcomFile($filePath, $conn) {
    $file = fopen($filePath, "r");
    $individuals = [];
    $currentIndi = null;

    if ($file) {
        while (($line = fgets($file)) !== false) {
            $line = trim($line);

            if (strpos($line, "0 @I") === 0) {
                if ($currentIndi) {
                    $individuals[] = $currentIndi;
                }
                $currentIndi = [
                    'id' => substr($line, 3, strpos($line, '@', 3) - 3),
                    'first_name' => '',
                    'last_name' => '',
                    'sex' => '',
                    'birth_date' => '',
                    'birth_place' => '',
                    'death_date' => '',
                    'death_place' => ''
                ];
            }

            if (strpos($line, "1 NAME") === 0) {
                $nameParts = explode("/", substr($line, 7));
                $currentIndi['first_name'] = trim($nameParts[0]);
                $currentIndi['last_name'] = trim($nameParts[1]);
            }

            if (strpos($line, "1 SEX") === 0) {
                $currentIndi['sex'] = substr($line, 6, 1);
            }

            if (strpos($line, "1 BIRT") === 0 || strpos($line, "1 DEAT") === 0) {
                $event = strpos($line, "1 BIRT") === 0 ? 'birth' : 'death';
                $dateLine = fgets($file);
                $placeLine = fgets($file);

                if (strpos(trim($dateLine), "2 DATE") === 0) {
                    $currentIndi[$event . '_date'] = date("Y-m-d", strtotime(substr(trim($dateLine), 7)));
                }

                if (strpos(trim($placeLine), "2 PLAC") === 0) {
                    $currentIndi[$event . '_place'] = trim(substr($placeLine, 7));
                }
            }
        }

        if ($currentIndi) {
            $individuals[] = $currentIndi;
        }

        fclose($file);

        foreach ($individuals as $indi) {
            $stmt = $conn->prepare("INSERT INTO gedcom_data (type, gedcom_id, first_name, last_name, sex, birth_date, birth_place, death_date, death_place) VALUES ('INDI', ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "ssssssss",
                $indi['id'],
                $indi['first_name'],
                $indi['last_name'],
                $indi['sex'],
                $indi['birth_date'],
                $indi['birth_place'],
                $indi['death_date'],
                $indi['death_place']
            );
            $stmt->execute();
            $stmt->close();
        }
    } else {
        echo "Erreur d'ouverture du fichier GEDCOM.";
    }
    $conn->close();
}
?>
