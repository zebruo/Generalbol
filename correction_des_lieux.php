<?php
$title = "Correction des lieux";
include 'head.php';
?>
<body>
<?php include 'menu.php'; ?>
<h1>Correction des lieux</h1>
<div class="container">
    <?php
    include 'connexion.php';

    $results = [];

    // Gérer la soumission du formulaire
    if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {
        $correctedPlaces = $_POST[ 'places' ];
        foreach ( $correctedPlaces as $originalPlace => $correctedPlace ) {
            if ( $originalPlace !== $correctedPlace ) {
                // Mettre à jour les lieux de naissance
                $stmt = $conn->prepare( "UPDATE gedcom_data SET birth_place = ? WHERE birth_place = ?" );
                $stmt->bind_param( "ss", $correctedPlace, $originalPlace );
                $stmt->execute();
                $stmt->close();

                // Mettre à jour les lieux de décès
                $stmt = $conn->prepare( "UPDATE gedcom_data SET death_place = ? WHERE death_place = ?" );
                $stmt->bind_param( "ss", $correctedPlace, $originalPlace );
                $stmt->execute();
                $stmt->close();

                $results[] = "Lieu mis à jour : " . htmlspecialchars( $originalPlace, ENT_QUOTES ) . " &rarr; " . htmlspecialchars( $correctedPlace, ENT_QUOTES );
            }
        }
    }

    if ( !empty( $results ) ) {
        echo "<div class='results'>";
        foreach ( $results as $result ) {
            echo "<p>" . $result . "</p>";
        }
        echo "</div>";
    }

    // Récupérer les lieux de naissance et de décès
    $sql = "SELECT birth_place, death_place FROM gedcom_data WHERE birth_place IS NOT NULL OR death_place IS NOT NULL";
    $result = $conn->query( $sql );

    $places = [];

    if ( $result->num_rows > 0 ) {
        // Stocker les données de chaque ligne
        while ( $row = $result->fetch_assoc() ) {
            if ( !empty( $row[ "birth_place" ] ) && !in_array( $row[ "birth_place" ], $places ) ) {
                $places[ $row[ "birth_place" ] ] = $row[ "birth_place" ];
            }
            if ( !empty( $row[ "death_place" ] ) && !in_array( $row[ "death_place" ], $places ) ) {
                $places[ $row[ "death_place" ] ] = $row[ "death_place" ];
            }
        }
    } else {
        echo "0 results";
    }

    // Fonction de comparaison qui tient compte des accents
    function comparePlaces( $a, $b ) {
        $coll = collator_create( 'fr_FR' );
        return collator_compare( $coll, $a, $b );
    }

    // Trier les lieux par ordre alphabétique en tenant compte des accents
    uasort( $places, 'comparePlaces' );

    // Afficher les lieux pour correction
    echo "<form action='' method='post'>";
    foreach ( $places as $place ) {
        echo "<div class='form-group'>";
        echo "<label>" . htmlspecialchars( $place, ENT_QUOTES ) . "</label>";
        echo "<input type='text' name='places[" . htmlspecialchars( $place, ENT_QUOTES ) . "]' value='" . htmlspecialchars( $place, ENT_QUOTES ) . "'>";
        echo "</div>";
    }
    echo "<button type='submit'>Corriger les lieux</button>";
    echo "</form>";

    $conn->close();
    ?>
</div>
</body>
</html>