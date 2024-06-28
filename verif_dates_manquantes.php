<?php
include 'connexion.php'; // Assurez-vous que ce fichier contient les détails de connexion à la base de données

// Requête pour récupérer les enregistrements avec birth_date ou death_date manquantes
$sql = "SELECT first_name, last_name, birth_date, death_date 
        FROM gedcom_data 
        WHERE birth_date IS NULL OR death_date IS NULL
        ORDER BY last_name, first_name";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>First Name</th><th>Last Name</th><th>Birth Date</th><th>Death Date</th></tr>";
    
    // Affichage des données
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["first_name"] . "</td>";
        echo "<td>" . $row["last_name"] . "</td>";
        echo "<td>" . (empty($row["birth_date"]) ? "Missing" : $row["birth_date"]) . "</td>";
        echo "<td>" . (empty($row["death_date"]) ? "Missing" : $row["death_date"]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>
