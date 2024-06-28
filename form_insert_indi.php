<?php
$title = "Nouvelle Personne";
include 'config/head.php';
?>

<body>
    <?php include 'config/menu.php'; ?>
    <h1>Ajouter une personne</h1>
    <form action="http://Generalbol/insert_indi.php" method="post" class="flex-form">
        <div class="form-column">
            <label for="sex">Genre:</label>
            <select id="sex" name="sex">
                <option value="M">Masculin</option>
                <option value="F">Féminin</option>
                <option value="U">inconnu</option>
            </select>
        </div>
        <div class="form-column">
            <label for="status">Statut :</label>
            <select id="status" name="status" required>
                <option value="alive">En vie</option>
                <option value="deceased">Décédé(e)</option>
            </select>
        </div>
        <div class="form-column">
            <label for="last_name">Nom:</label>
            <input type="text" id="last_name" name="last_name" required oninput="convertToUpperCase()">
        </div>
        <div class="form-column">
            <label for="first_name">Prénom:</label>
            <input type="text" id="first_name" name="first_name" required>
        </div>
        <div class="form-column">
            <label for="birth_date">Date de naissance:</label>
            <input type="date" id="birth_date" name="birth_date">
        </div>
        <div class="form-column">
            <label for="birth_place">Lieu :</label>
            <input type="text" id="birth_place" name="birth_place">
        </div>
        <div class="form-column" id="death_details" style="display: none;">
            <label for="death_date">Date de décès :</label>
            <input type="date" id="death_date" name="death_date">
            <label for="death_place">Lieu :</label>
            <input type="text" id="death_place" name="death_place">
        </div>
        <div class="form-column">
            <label for="occupation">Profession :</label>
            <input type="text" id="occupation" name="occupation">
        </div>
        <div class="form-column">
            <label for="notes">Notes :</label>
            <textarea id="notes" name="notes"></textarea>
        </div>
        <div class="form-column">
            <label for="marriage_date">Date de mariage:</label>
            <input type="date" id="marriage_date" name="marriage_date">
        </div>
        <div class="form-column">
            <label for="marriage_place">Lieu de mariage :</label>
            <input type="text" id="marriage_place" name="marriage_place">
        </div>
        <div class="form-actions">
            <button type="submit">Ajouter</button>
            <button type="button" onclick="window.location.href='index.php'">Annuler</button>
        </div>
    </form>
    <script>
        // Fonction pour convertir le texte en majuscules
        function convertToUpperCase() {
            // Récupère l'élément input par son ID
            let input = document.getElementById('last_name');
            // Convertit la valeur de l'input en majuscules
            input.value = input.value.toUpperCase();
        }

        // Ajoute un écouteur d'événement à l'élément avec l'ID 'status'
        document.getElementById('status').addEventListener('change', function() {
            // Récupère l'élément avec l'ID 'death_details'
            var deathDetails = document.getElementById('death_details');

            // Vérifie si la valeur sélectionnée est 'deceased'
            if (this.value === 'deceased') {
                // Si oui, affiche l'élément 'death_details'
                deathDetails.style.display = 'block';
            } else {
                // Sinon, cache l'élément 'death_details'
                deathDetails.style.display = 'none';
            }
        });
    </script>
</body>

</html>