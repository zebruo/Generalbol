<?php
// Inclure le fichier de connexion à la base de données
include 'config/connexion.php';

// Requête SQL pour récupérer les individus depuis la table gedcom_data, triés par last_name
$sql = "SELECT * FROM gedcom_data ORDER BY last_name";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    // Convertir le résultat en tableau associatif
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Fermer la connexion à la base de données
$conn->close();

// Envoyer les données sous forme de JSON
header('Content-Type: application/json');
echo json_encode($data);
