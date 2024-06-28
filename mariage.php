<<<<<<< HEAD
<?php
// Inclure le fichier de connexion à la base de données
include 'config/connexion.php';

// Initialiser le tableau pour stocker les mariages
$mariages = [];

// Requête SQL pour récupérer les personnes ayant la même date de mariage et qui n'ont pas encore de spouse_id
$sql = "SELECT g1.id AS spouse1_id, g2.id AS spouse2_id, g1.marriage_date, g1.marriage_place
        FROM gedcom_data g1
        JOIN gedcom_data g2 ON g1.marriage_date = g2.marriage_date AND g1.id != g2.id
        WHERE g1.marriage_date IS NOT NULL
        AND g1.spouse_id IS NULL
        AND g2.spouse_id IS NULL
        ORDER BY g1.marriage_date, g1.id";

$result = $conn->query( $sql );

if ( $result->num_rows > 0 ) {
    // Tableau pour stocker les mariages traités pour éviter les doublons
    $processedMarriages = [];

    while ( $row = $result->fetch_assoc() ) {
        $spouse1_id = $row[ 'spouse1_id' ];
        $spouse2_id = $row[ 'spouse2_id' ];
        $marriage_date = $row[ 'marriage_date' ];
        $marriage_place = $row[ 'marriage_place' ];

        // Vérifier si cette paire de mariage a déjà été traitée
        if ( in_array( [ $spouse1_id, $spouse2_id ], $processedMarriages ) || in_array( [ $spouse2_id, $spouse1_id ], $processedMarriages ) ) {
            continue;
        }

        // Ajouter cette paire au tableau des mariages
        $mariages[] = [
            'spouse1_id' => $spouse1_id,
            'spouse2_id' => $spouse2_id,
            'marriage_date' => $marriage_date,
            'marriage_place' => $marriage_place
        ];

        // Marquer cette paire de mariage comme traitée
        $processedMarriages[] = [ $spouse1_id, $spouse2_id ];
    }
} else {
    echo "Aucun mariage trouvé avec les critères spécifiés.\n";
}

// Fermer la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Mise à jour des mariages</title>
</head>
<body>
<h1>Mise à jour des mariages</h1>
<form action="mariage.php" method="post">
    <?php foreach ($mariages as $index => $mariage) : ?>
    <div>
        <p>Voulez-vous mettre à jour le mariage entre les individus avec ID <?php echo $mariage['spouse1_id']; ?> et <?php echo $mariage['spouse2_id']; ?> le <?php echo $mariage['marriage_date']; ?> à <?php echo $mariage['marriage_place']; ?> ?</p>
        <input type="radio" name="confirm[<?php echo $index; ?>]" value="oui">
        Oui
        <input type="radio" name="confirm[<?php echo $index; ?>]" value="non" checked>
        Non
        <input type="hidden" name="spouse1_id[<?php echo $index; ?>]" value="<?php echo $mariage['spouse1_id']; ?>">
        <input type="hidden" name="spouse2_id[<?php echo $index; ?>]" value="<?php echo $mariage['spouse2_id']; ?>">
        <input type="hidden" name="marriage_date[<?php echo $index; ?>]" value="<?php echo $mariage['marriage_date']; ?>">
        <input type="hidden" name="marriage_place[<?php echo $index; ?>]" value="<?php echo $mariage['marriage_place']; ?>">
    </div>
    <?php endforeach; ?>
    <button type="submit">Mettre à jour les mariages sélectionnés</button>
</form>
<?php
// Inclure le fichier de connexion à la base de données
include 'config/connexion.php';

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
    $confirmations = $_POST[ 'confirm' ] ?? [];
    $spouse1_ids = $_POST[ 'spouse1_id' ] ?? [];
    $spouse2_ids = $_POST[ 'spouse2_id' ] ?? [];
    $marriage_dates = $_POST[ 'marriage_date' ] ?? [];
    $marriage_places = $_POST[ 'marriage_place' ] ?? [];

    foreach ( $confirmations as $index => $confirmation ) {
        if ( strtolower( $confirmation ) === 'oui' ) {
            $spouse1_id = $spouse1_ids[ $index ];
            $spouse2_id = $spouse2_ids[ $index ];
            $marriage_date = $marriage_dates[ $index ];
            $marriage_place = $marriage_places[ $index ];

            // Vérifier si les colonnes spouse_id sont encore nulles avant mise à jour
            $check1 = "SELECT spouse_id FROM gedcom_data WHERE id = $spouse1_id";
            $check2 = "SELECT spouse_id FROM gedcom_data WHERE id = $spouse2_id";
            $result1 = $conn->query( $check1 );
            $result2 = $conn->query( $check2 );

            if ( $result1->num_rows > 0 && $result2->num_rows > 0 ) {
                $row1 = $result1->fetch_assoc();
                $row2 = $result2->fetch_assoc();

                if ( is_null( $row1[ 'spouse_id' ] ) && is_null( $row2[ 'spouse_id' ] ) ) {
                    // Mettre à jour la colonne spouse_id pour chaque individu
                    $update1 = "UPDATE gedcom_data SET spouse_id = $spouse2_id WHERE id = $spouse1_id";
                    $update2 = "UPDATE gedcom_data SET spouse_id = $spouse1_id WHERE id = $spouse2_id";

                    if ( $conn->query( $update1 ) === TRUE && $conn->query( $update2 ) === TRUE ) {
                        echo "Les colonnes spouse_id ont été mises à jour avec succès pour les individus $spouse1_id et $spouse2_id.<br>";
                    } else {
                        echo "Erreur lors de la mise à jour des colonnes spouse_id : " . $conn->error . "<br>";
                    }
                } else {
                    echo "Les colonnes spouse_id ne sont pas nulles pour les individus $spouse1_id et/ou $spouse2_id. Mise à jour annulée.<br>";
                }
            }
        } else {
            echo "Vous avez choisi de ne pas mettre à jour les colonnes spouse_id pour le mariage entre les individus $spouse1_id et $spouse2_id.<br>";
        }
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>
</body>
</html>
=======
<?php
// Inclure le fichier de connexion à la base de données
include 'config/connexion.php';

// Initialiser le tableau pour stocker les mariages
$mariages = [];

// Requête SQL pour récupérer les personnes ayant la même date de mariage et qui n'ont pas encore de spouse_id
$sql = "SELECT g1.id AS spouse1_id, g2.id AS spouse2_id, g1.marriage_date, g1.marriage_place
        FROM gedcom_data g1
        JOIN gedcom_data g2 ON g1.marriage_date = g2.marriage_date AND g1.id != g2.id
        WHERE g1.marriage_date IS NOT NULL
        AND g1.spouse_id IS NULL
        AND g2.spouse_id IS NULL
        ORDER BY g1.marriage_date, g1.id";

$result = $conn->query( $sql );

if ( $result->num_rows > 0 ) {
    // Tableau pour stocker les mariages traités pour éviter les doublons
    $processedMarriages = [];

    while ( $row = $result->fetch_assoc() ) {
        $spouse1_id = $row[ 'spouse1_id' ];
        $spouse2_id = $row[ 'spouse2_id' ];
        $marriage_date = $row[ 'marriage_date' ];
        $marriage_place = $row[ 'marriage_place' ];

        // Vérifier si cette paire de mariage a déjà été traitée
        if ( in_array( [ $spouse1_id, $spouse2_id ], $processedMarriages ) || in_array( [ $spouse2_id, $spouse1_id ], $processedMarriages ) ) {
            continue;
        }

        // Ajouter cette paire au tableau des mariages
        $mariages[] = [
            'spouse1_id' => $spouse1_id,
            'spouse2_id' => $spouse2_id,
            'marriage_date' => $marriage_date,
            'marriage_place' => $marriage_place
        ];

        // Marquer cette paire de mariage comme traitée
        $processedMarriages[] = [ $spouse1_id, $spouse2_id ];
    }
} else {
    echo "Aucun mariage trouvé avec les critères spécifiés.\n";
}

// Fermer la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Mise à jour des mariages</title>
</head>
<body>
<h1>Mise à jour des mariages</h1>
<form action="mariage.php" method="post">
    <?php foreach ($mariages as $index => $mariage) : ?>
    <div>
        <p>Voulez-vous mettre à jour le mariage entre les individus avec ID <?php echo $mariage['spouse1_id']; ?> et <?php echo $mariage['spouse2_id']; ?> le <?php echo $mariage['marriage_date']; ?> à <?php echo $mariage['marriage_place']; ?> ?</p>
        <input type="radio" name="confirm[<?php echo $index; ?>]" value="oui">
        Oui
        <input type="radio" name="confirm[<?php echo $index; ?>]" value="non" checked>
        Non
        <input type="hidden" name="spouse1_id[<?php echo $index; ?>]" value="<?php echo $mariage['spouse1_id']; ?>">
        <input type="hidden" name="spouse2_id[<?php echo $index; ?>]" value="<?php echo $mariage['spouse2_id']; ?>">
        <input type="hidden" name="marriage_date[<?php echo $index; ?>]" value="<?php echo $mariage['marriage_date']; ?>">
        <input type="hidden" name="marriage_place[<?php echo $index; ?>]" value="<?php echo $mariage['marriage_place']; ?>">
    </div>
    <?php endforeach; ?>
    <button type="submit">Mettre à jour les mariages sélectionnés</button>
</form>
<?php
// Inclure le fichier de connexion à la base de données
include 'config/connexion.php';

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
    $confirmations = $_POST[ 'confirm' ] ?? [];
    $spouse1_ids = $_POST[ 'spouse1_id' ] ?? [];
    $spouse2_ids = $_POST[ 'spouse2_id' ] ?? [];
    $marriage_dates = $_POST[ 'marriage_date' ] ?? [];
    $marriage_places = $_POST[ 'marriage_place' ] ?? [];

    foreach ( $confirmations as $index => $confirmation ) {
        if ( strtolower( $confirmation ) === 'oui' ) {
            $spouse1_id = $spouse1_ids[ $index ];
            $spouse2_id = $spouse2_ids[ $index ];
            $marriage_date = $marriage_dates[ $index ];
            $marriage_place = $marriage_places[ $index ];

            // Vérifier si les colonnes spouse_id sont encore nulles avant mise à jour
            $check1 = "SELECT spouse_id FROM gedcom_data WHERE id = $spouse1_id";
            $check2 = "SELECT spouse_id FROM gedcom_data WHERE id = $spouse2_id";
            $result1 = $conn->query( $check1 );
            $result2 = $conn->query( $check2 );

            if ( $result1->num_rows > 0 && $result2->num_rows > 0 ) {
                $row1 = $result1->fetch_assoc();
                $row2 = $result2->fetch_assoc();

                if ( is_null( $row1[ 'spouse_id' ] ) && is_null( $row2[ 'spouse_id' ] ) ) {
                    // Mettre à jour la colonne spouse_id pour chaque individu
                    $update1 = "UPDATE gedcom_data SET spouse_id = $spouse2_id WHERE id = $spouse1_id";
                    $update2 = "UPDATE gedcom_data SET spouse_id = $spouse1_id WHERE id = $spouse2_id";

                    if ( $conn->query( $update1 ) === TRUE && $conn->query( $update2 ) === TRUE ) {
                        echo "Les colonnes spouse_id ont été mises à jour avec succès pour les individus $spouse1_id et $spouse2_id.<br>";
                    } else {
                        echo "Erreur lors de la mise à jour des colonnes spouse_id : " . $conn->error . "<br>";
                    }
                } else {
                    echo "Les colonnes spouse_id ne sont pas nulles pour les individus $spouse1_id et/ou $spouse2_id. Mise à jour annulée.<br>";
                }
            }
        } else {
            echo "Vous avez choisi de ne pas mettre à jour les colonnes spouse_id pour le mariage entre les individus $spouse1_id et $spouse2_id.<br>";
        }
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>
</body>
</html>
>>>>>>> origin/main
