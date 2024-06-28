<?php
$title = "Généralbol";
include 'config/head.php';
?>

<body>
    <?php include 'config/menu.php'; ?>
    <div class="statistics">
        <p>L’arbre généalogique est un outil précieux pour comprendre d’où nous venons et pour honorer la mémoire de nos ancêtres.<br>
            Dans notre cas, l’arbre se compose de quatre branches principales qui représentent les lignées familiales de Durel, Truffert, Hélaine et Leconte. </p>
        <?php
        include 'config/connexion.php';

        // Requête pour le nombre total d'individus
        $sql_total = "SELECT COUNT(*) AS total FROM gedcom_data WHERE type = 'INDI'";
        $result_total = $conn->query($sql_total);
        $total_individuals = ($result_total->num_rows > 0) ? $result_total->fetch_assoc()['total'] : 0;

        // Requête pour le nombre d'individus décédés
        $sql_deceased = "SELECT COUNT(*) AS deceased FROM gedcom_data WHERE type = 'INDI' AND death_date IS NOT NULL";
        $result_deceased = $conn->query($sql_deceased);
        $deceased_individuals = ($result_deceased->num_rows > 0) ? $result_deceased->fetch_assoc()['deceased'] : 0;

        // Requête pour le nombre d'individus encore en vie
        $sql_alive = "SELECT COUNT(*) AS alive FROM gedcom_data WHERE type = 'INDI' AND death_date IS NULL";
        $result_alive = $conn->query($sql_alive);
        $alive_individuals = ($result_alive->num_rows > 0) ? $result_alive->fetch_assoc()['alive'] : 0;

        // Requête pour le nombre de lieux répertoriés
        $sql_places = "SELECT COUNT(DISTINCT birth_place) + COUNT(DISTINCT death_place) AS places FROM gedcom_data WHERE birth_place IS NOT NULL OR death_place IS NOT NULL";
        $result_places = $conn->query($sql_places);
        $total_places = ($result_places->num_rows > 0) ? $result_places->fetch_assoc()['places'] : 0;

        // Requête pour le nombre de mariages
        $sql_marriages = "SELECT COUNT(DISTINCT marriage_date) AS marriages FROM gedcom_data WHERE marriage_date IS NOT NULL";
        $result_marriages = $conn->query($sql_marriages);
        $total_marriages = ($result_marriages->num_rows > 0) ? $result_marriages->fetch_assoc()['marriages'] : 0;


        echo "<p>Nombre total d'individus : $total_individuals</p>";
        echo "<p>Individus décédés : $deceased_individuals</p>";
        echo "<p>Individus encore en vie : $alive_individuals</p>";
        echo "<p>Lieux répertoriés : $total_places</p>";
        echo "<p>Nombre de mariages : $total_marriages</p>";

        // Fermer la connexion après avoir terminé l'utilisation
        $conn->close();
        ?>
    </div>
</body>

</html>