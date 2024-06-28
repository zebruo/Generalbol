<?php
// Inclure le fichier de connexion à la base de données
include 'connexion.php';

// Vérifier si le formulaire a été soumis
if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
    // Récupérer les données du formulaire
    $sex = $_POST[ 'sex' ];
    $status = $_POST[ 'status' ];
    $last_name = $_POST[ 'last_name' ];
    $first_name = $_POST[ 'first_name' ];
    $birth_date = !empty( $_POST[ 'birth_date' ] ) ? $_POST[ 'birth_date' ] : null;
    $birth_place = !empty( $_POST[ 'birth_place' ] ) ? $_POST[ 'birth_place' ] : null;
    $death_date = $status === 'deceased' ? ( !empty( $_POST[ 'death_date' ] ) ? $_POST[ 'death_date' ] : null ) : null;
    $death_place = $status === 'deceased' ? ( !empty( $_POST[ 'death_place' ] ) ? $_POST[ 'death_place' ] : null ) : null;
    $occupation = !empty( $_POST[ 'occupation' ] ) ? $_POST[ 'occupation' ] : null;
    $notes = !empty( $_POST[ 'notes' ] ) ? $_POST[ 'notes' ] : null;
    $marriage_date = !empty( $_POST[ 'marriage_date' ] ) ? $_POST[ 'marriage_date' ] : null;
    $marriage_place = !empty( $_POST[ 'marriage_place' ] ) ? $_POST[ 'marriage_place' ] : null;
    $is_deceased = $status === 'deceased' ? 1 : 0;

    // Vérifier si l'individu existe déjà dans la base de données
    $check_sql = "SELECT id FROM gedcom_data WHERE first_name = ? AND last_name = ?";
    $stmt = $conn->prepare( $check_sql );
    $stmt->bind_param( "ss", $first_name, $last_name );
    $stmt->execute();
    $stmt->store_result();

    if ( $stmt->num_rows > 0 ) {
        // L'individu existe déjà, redirection vers la page de modification
        $stmt->bind_result( $existing_id );
        $stmt->fetch();
        $stmt->close();
        header( "Location: modify_indi.php?id=$existing_id" );
        exit;
    } else {
        // L'individu n'existe pas, insérer un nouvel enregistrement
        $stmt->close();
        $insert_sql = "INSERT INTO gedcom_data (type, gedcom_id, parent_id, spouse_id, value, first_name, last_name, sex, birth_date, birth_place, death_date, death_place, occupation, notes, marriage_date, marriage_place, is_deceased)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare( $insert_sql );

        $type = 'INDI';
        $gedcom_id = null; // à remplacer par l'ID GEDCOM approprié si disponible
        $parent_id = null;
        $spouse_id = null;
        $value = null;

        $stmt->bind_param( "siisssssssssssssi", $type, $gedcom_id, $parent_id, $spouse_id, $value, $first_name, $last_name, $sex, $birth_date, $birth_place, $death_date, $death_place, $occupation, $notes, $marriage_date, $marriage_place, $is_deceased );

        // Exécuter la requête et vérifier si elle a réussi
        if ( $stmt->execute() ) {
            echo "Nouvel individu ajouté avec succès: " . htmlspecialchars( $last_name ) . " " . htmlspecialchars( $first_name ) . ".";
            echo "<form action='index.php' method='post'><button type='submit'>OK</button></form>";
        } else {
            echo "Erreur: " . $stmt->error;
        }

        // Fermer la requête préparée
        $stmt->close();
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>
