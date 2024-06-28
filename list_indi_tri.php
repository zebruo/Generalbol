<?php
$title = "Liste des individus";
include 'head.php';
?>
<body>
<?php include 'menu.php'; ?>
<div class="container">
    <h1>Liste des individus</h1>
    
    <!-- Formulaire de tri -->
    <form method="GET" action="">
        <div class="form-group"> 
            <!--<label for="sort">Trier par : </label>-->
            <select name="sort" id="sort">
                <option value="last_name_asc" <?php if (!isset($_GET['sort']) || $_GET['sort'] == 'last_name_asc') echo 'selected'; ?>>Nom (A-Z)</option>
                <option value="last_name_desc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'last_name_desc') echo 'selected'; ?>>Nom (Z-A)</option>
                <option value="first_name_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'first_name_asc') echo 'selected'; ?>>Prénom (A-Z)</option>
                <option value="first_name_desc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'first_name_desc') echo 'selected'; ?>>Prénom (Z-A)</option>
                <option value="birth_date_desc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'birth_date_desc') echo 'selected'; ?>>Naissances les + récentes</option>
                <option value="birth_date_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'birth_date_asc') echo 'selected'; ?>>Naissances les + anciennes</option>
                <option value="death_date_desc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'death_date_desc') echo 'selected'; ?>>Décès les + récents</option>
                <option value="death_date_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'death_date_asc') echo 'selected'; ?>>Décès les + anciens</option>
            </select>
        </div>
        <button type="submit">Trier</button>
    </form>
    
    <!-- Formulaire de filtrage par lettre -->
    <div class="alphabet-filter">
        <?php
        $alphabet = range( 'A', 'Z' );
        $selectedLetter = isset( $_GET[ 'letter' ] ) ? $_GET[ 'letter' ] : '';
        foreach ( $alphabet as $letter ) {
            $class = ( $letter == $selectedLetter ) ? 'active' : '';
            echo '<a href="?letter=' . $letter . '" class="' . $class . '">' . $letter . '</a> ';
        }
        ?>
    </div>
    <div class="listIndi">
        <?php
        include 'connexion.php';

        // Requête pour sélectionner les individus
        $sql = "SELECT first_name, last_name, sex, birth_date, death_date, is_deceased FROM gedcom_data WHERE type = 'INDI'";

        // Ajouter une condition de filtre par lettre si une lettre est sélectionnée
        if ( isset( $_GET[ 'letter' ] ) && preg_match( '/^[A-Z]$/', $_GET[ 'letter' ] ) ) {
            $letter = $_GET[ 'letter' ];
            // Ajouter une condition à la requête SQL pour filtrer les individus dont le nom commence par la lettre sélectionnée
            $sql .= " AND (last_name LIKE '$letter%')";
        }

        $result = $conn->query( $sql );

        // Variable pour stocker les individus
        $individuals = [];

        // Vérifier si des résultats ont été retournés
        if ( $result->num_rows > 0 ) {
            while ( $row = $result->fetch_assoc() ) {
                // Stocker chaque individu dans un tableau
                $individuals[] = $row;
            }
        }

        // Fonction de comparaison qui tient compte des accents
        function compareNames( $a, $b, $key, $order ) {
            $coll = collator_create( 'fr_FR' );
            if ( $order == 'asc' ) {
                return collator_compare( $coll, $a[ $key ], $b[ $key ] );
            } else {
                return collator_compare( $coll, $b[ $key ], $a[ $key ] );
            }
        }

        // Fonction de formatage pour les informations de naissance et de décès
        function formatInfo( $person ) {
            $birth_date = is_null( $person[ 'birth_date' ] ) ? '?' : date( 'Y', strtotime( $person[ 'birth_date' ] ) );
            if ( $person[ 'is_deceased' ] == 1 ) {
                $death_date = is_null( $person[ 'death_date' ] ) ? '?' : date( 'Y', strtotime( $person[ 'death_date' ] ) );
                return $birth_date . ' - ' . $death_date;
            } else {
                $type = ( $person[ 'sex' ] == 'M' ) ? 'né en' : 'née en';
                return $type . ' ' . $birth_date;
            }
        }

        // Appliquer le tri selon l'option sélectionnée
        if ( !empty( $individuals ) ) {
            if ( isset( $_GET[ 'sort' ] ) ) {
                switch ( $_GET[ 'sort' ] ) {
                    case 'last_name_asc':
                        usort( $individuals, function ( $a, $b ) {
                            return compareNames( $a, $b, 'last_name', 'asc' );
                        } );
                        break;
                    case 'last_name_desc':
                        usort( $individuals, function ( $a, $b ) {
                            return compareNames( $a, $b, 'last_name', 'desc' );
                        } );
                        break;
                    case 'first_name_asc':
                        usort( $individuals, function ( $a, $b ) {
                            return compareNames( $a, $b, 'first_name', 'asc' );
                        } );
                        break;
                    case 'first_name_desc':
                        usort( $individuals, function ( $a, $b ) {
                            return compareNames( $a, $b, 'first_name', 'desc' );
                        } );
                        break;

                    case 'birth_date_asc':
                        usort( $individuals, function ( $a, $b ) {
                            if ( $a[ 'birth_date' ] == $b[ 'birth_date' ] ) return 0;
                            return ( $a[ 'birth_date' ] < $b[ 'birth_date' ] ) ? -1 : 1;
                        } );
                        break;
                    case 'birth_date_desc':
                        usort( $individuals, function ( $a, $b ) {
                            if ( $a[ 'birth_date' ] == $b[ 'birth_date' ] ) return 0;
                            return ( $a[ 'birth_date' ] > $b[ 'birth_date' ] ) ? -1 : 1;
                        } );
                        break;
                    case 'death_date_asc':
                        // Filtrer les individus décédés avant de trier
                        $deceased_individuals = array_filter( $individuals, function ( $person ) {
                            return $person[ 'is_deceased' ] == 1;
                        } );
                        usort( $deceased_individuals, function ( $a, $b ) {
                            if ( $a[ 'death_date' ] == $b[ 'death_date' ] ) return 0;
                            return ( $a[ 'death_date' ] < $b[ 'death_date' ] ) ? -1 : 1;
                        } );
                        $individuals = $deceased_individuals;
                        break;
                    case 'death_date_desc':
                        // Filtrer les individus décédés avant de trier
                        $deceased_individuals = array_filter( $individuals, function ( $person ) {
                            return $person[ 'is_deceased' ] == 1;
                        } );
                        usort( $deceased_individuals, function ( $a, $b ) {
                            if ( $a[ 'death_date' ] == $b[ 'death_date' ] ) return 0;
                            return ( $a[ 'death_date' ] > $b[ 'death_date' ] ) ? -1 : 1;
                        } );
                        $individuals = $deceased_individuals;
                        break;
                }
            } else {
                // Par défaut, tri par nom (A-Z)
                usort( $individuals, function ( $a, $b ) {
                    return strcmp( $a[ 'last_name' ], $b[ 'last_name' ] );
                } );
            }

            // Afficher chaque individu avec les informations formatées
            foreach ( $individuals as $person ) {
                $class = ( $person[ 'sex' ] == 'M' ) ? 'person-male' : 'person-female';
                echo '<div class="person ' . $class . '">';

                // Affichage du prénom en premier pour les options Prénom (A-Z) ou Prénom (Z-A)
                if ( isset( $_GET[ 'sort' ] ) && ( $_GET[ 'sort' ] == 'first_name_asc' || $_GET[ 'sort' ] == 'first_name_desc' ) ) {
                    echo '<h2>' . $person[ 'first_name' ] . ' ' . $person[ 'last_name' ] . '&nbsp;&nbsp;&nbsp;<span class="small-text">' . formatInfo( $person ) . '</span></h2>';
                } else {
                    echo '<h2>' . $person[ 'last_name' ] . ' ' . $person[ 'first_name' ] . '&nbsp;&nbsp;&nbsp;<span class="small-text">' . formatInfo( $person ) . '</span></h2>';
                }
                echo '</div>';
            }
        } else {
            echo '<p>Aucune personne trouvée.</p>';
        }

        // Fermer la connexion
        $conn->close();
        ?>
    </div>
</div>
</body>
</html>