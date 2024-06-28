<<<<<<< HEAD
<?php
// Inclure le fichier de connexion à la base de données
include 'connexion.php';

// Initialiser la variable pour les messages
$message = '';

// Récupérer l'ID de l'individu à modifier
$individual_id = $_GET[ 'id' ] ?? null;

if ( !$individual_id ) {
    $message = "ID de l'individu manquant.";
    exit;
}

// Récupérer les informations actuelles de l'individu
$sql = "SELECT * FROM gedcom_data WHERE id = ?";
$stmt = $conn->prepare( $sql );
$stmt->bind_param( "i", $individual_id );
$stmt->execute();
$result = $stmt->get_result();

if ( $result->num_rows === 0 ) {
    $message = "Individu non trouvé.";
    exit;
}

$individual = $result->fetch_assoc();

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

    // Mettre à jour les informations de l'individu
    $update_sql = "UPDATE gedcom_data 
                   SET first_name = ?, last_name = ?, sex = ?, birth_date = ?, birth_place = ?, death_date = ?, death_place = ?, occupation = ?, notes = ?, marriage_date = ?, marriage_place = ?, is_deceased = ? 
                   WHERE id = ?";
    $stmt = $conn->prepare( $update_sql );
    $stmt->bind_param( "ssssssssssssi", $first_name, $last_name, $sex, $birth_date, $birth_place, $death_date, $death_place, $occupation, $notes, $marriage_date, $marriage_place, $is_deceased, $individual_id );

    // Exécuter la requête et vérifier si elle a réussi
    if ( $stmt->execute() ) {
        $message = "Les informations de l'individu ont été mises à jour avec succès.";
    } else {
        $message = "Erreur: " . $stmt->error;
    }

    // Fermer la requête préparée
    $stmt->close();
}

// Fermer la connexion à la base de données
$conn->close();
?>
<?php
$title = "Modifier une personne";
include 'head.php';
?>
<body>
<?php include 'menu.php'; ?>
<h1>Modifier une personne</h1>
<form action="modify_indi.php?id=<?php echo $individual_id; ?>" method="post" class="flex-form">
    <div class="form-column">
        <label for="sex">Genre:</label>
        <select id="sex" name="sex">
            <option value="M" <?php if ($individual['sex'] == 'M') echo 'selected'; ?>>Masculin</option>
            <option value="F" <?php if ($individual['sex'] == 'F') echo 'selected'; ?>>Féminin</option>
            <option value="U" <?php if ($individual['sex'] == 'U') echo 'selected'; ?>>Inconnu</option>
        </select>
    </div>
    <div class="form-column">
        <label for="status">Statut :</label>
        <select id="status" name="status" required>
            <option value="alive" <?php if ($individual['is_deceased'] == 0) echo 'selected'; ?>>En vie</option>
            <option value="deceased" <?php if ($individual['is_deceased'] == 1) echo 'selected'; ?>>Décédé(e)</option>
        </select>
    </div>
    <div class="form-column">
        <label for="last_name">Nom:</label>
        <input type="text" id="last_name" name="last_name" required value="<?php echo htmlspecialchars($individual['last_name'] ?? ''); ?>" oninput="convertToUpperCase()">
    </div>
    <div class="form-column">
        <label for="first_name">Prénom:</label>
        <input type="text" id="first_name" name="first_name" required value="<?php echo htmlspecialchars($individual['first_name'] ?? ''); ?>">
    </div>
    <div class="form-column">
        <label for="birth_date">Date de naissance:</label>
        <input type="date" id="birth_date" name="birth_date" value="<?php echo $individual['birth_date'] ?? ''; ?>">
    </div>
    <div class="form-column">
        <label for="birth_place">Lieu :</label>
        <input type="text" id="birth_place" name="birth_place" value="<?php echo htmlspecialchars($individual['birth_place'] ?? ''); ?>">
    </div>
    <div class="form-column" id="death_details" style="display: <?php echo ($individual['is_deceased'] == 1) ? 'block' : 'none'; ?>;">
        <label for="death_date">Date de décès :</label>
        <input type="date" id="death_date" name="death_date" value="<?php echo $individual['death_date'] ?? ''; ?>">
        <label for="death_place">Lieu :</label>
        <input type="text" id="death_place" name="death_place" value="<?php echo htmlspecialchars($individual['death_place'] ?? ''); ?>">
    </div>
    <div class="form-column">
        <label for="occupation">Profession :</label>
        <input type="text" id="occupation" name="occupation" value="<?php echo htmlspecialchars($individual['occupation'] ?? ''); ?>">
    </div>
    <div class="form-column">
        <label for="notes">Notes :</label>
        <textarea id="notes" name="notes"><?php echo htmlspecialchars($individual['notes'] ?? ''); ?></textarea>
    </div>
    <div class="form-column">
        <label for="marriage_date">Date de mariage:</label>
        <input type="date" id="marriage_date" name="marriage_date" value="<?php echo $individual['marriage_date'] ?? ''; ?>">
    </div>
    <div class="form-column">
        <label for="marriage_place">Lieu de mariage:</label>
        <input type="text" id="marriage_place" name="marriage_place" value="<?php echo htmlspecialchars($individual['marriage_place'] ?? ''); ?>">
    </div>
    <div class="form-actions">
        <button type="submit">Mettre à jour</button>
    </div>
</form>
<div id="message-container" class="message-container"></div>
<script>
    // Fonction pour convertir le texte en majuscules
    function convertToUpperCase() {
        // Récupère l'élément input par son ID
        let input = document.getElementById('last_name');
        // Convertit la valeur de l'input en majuscules
        input.value = input.value.toUpperCase();
    }

    // Ajoute un écouteur d'événement à l'élément avec l'ID 'status'
    document.getElementById('status').addEventListener('change', function () {
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
<script>
    // JavaScript pour afficher le message de succès ou d'erreur
    document.addEventListener('DOMContentLoaded', function() {
        var messageContainer = document.getElementById('message-container');
        var message = "<?php echo addslashes($message); ?>"; // PHP message avec échappement des guillemets

        // Vérifie si le message n'est pas vide
        if (message.trim() !== '') {
            // Crée un élément div pour afficher le message
            var messageDiv = document.createElement('div');
            messageDiv.className = 'message';
            messageDiv.textContent = message;

            // Ajoute le message à la div message-container
            messageContainer.appendChild(messageDiv);
        }
    });
</script>
</body>
=======
<?php
// Inclure le fichier de connexion à la base de données
include 'connexion.php';

// Initialiser la variable pour les messages
$message = '';

// Récupérer l'ID de l'individu à modifier
$individual_id = $_GET[ 'id' ] ?? null;

if ( !$individual_id ) {
    $message = "ID de l'individu manquant.";
    exit;
}

// Récupérer les informations actuelles de l'individu
$sql = "SELECT * FROM gedcom_data WHERE id = ?";
$stmt = $conn->prepare( $sql );
$stmt->bind_param( "i", $individual_id );
$stmt->execute();
$result = $stmt->get_result();

if ( $result->num_rows === 0 ) {
    $message = "Individu non trouvé.";
    exit;
}

$individual = $result->fetch_assoc();

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

    // Mettre à jour les informations de l'individu
    $update_sql = "UPDATE gedcom_data 
                   SET first_name = ?, last_name = ?, sex = ?, birth_date = ?, birth_place = ?, death_date = ?, death_place = ?, occupation = ?, notes = ?, marriage_date = ?, marriage_place = ?, is_deceased = ? 
                   WHERE id = ?";
    $stmt = $conn->prepare( $update_sql );
    $stmt->bind_param( "ssssssssssssi", $first_name, $last_name, $sex, $birth_date, $birth_place, $death_date, $death_place, $occupation, $notes, $marriage_date, $marriage_place, $is_deceased, $individual_id );

    // Exécuter la requête et vérifier si elle a réussi
    if ( $stmt->execute() ) {
        $message = "Les informations de l'individu ont été mises à jour avec succès.";
    } else {
        $message = "Erreur: " . $stmt->error;
    }

    // Fermer la requête préparée
    $stmt->close();
}

// Fermer la connexion à la base de données
$conn->close();
?>
<?php
$title = "Modifier une personne";
include 'head.php';
?>
<body>
<?php include 'menu.php'; ?>
<h1>Modifier une personne</h1>
<form action="modify_indi.php?id=<?php echo $individual_id; ?>" method="post" class="flex-form">
    <div class="form-column">
        <label for="sex">Genre:</label>
        <select id="sex" name="sex">
            <option value="M" <?php if ($individual['sex'] == 'M') echo 'selected'; ?>>Masculin</option>
            <option value="F" <?php if ($individual['sex'] == 'F') echo 'selected'; ?>>Féminin</option>
            <option value="U" <?php if ($individual['sex'] == 'U') echo 'selected'; ?>>Inconnu</option>
        </select>
    </div>
    <div class="form-column">
        <label for="status">Statut :</label>
        <select id="status" name="status" required>
            <option value="alive" <?php if ($individual['is_deceased'] == 0) echo 'selected'; ?>>En vie</option>
            <option value="deceased" <?php if ($individual['is_deceased'] == 1) echo 'selected'; ?>>Décédé(e)</option>
        </select>
    </div>
    <div class="form-column">
        <label for="last_name">Nom:</label>
        <input type="text" id="last_name" name="last_name" required value="<?php echo htmlspecialchars($individual['last_name'] ?? ''); ?>" oninput="convertToUpperCase()">
    </div>
    <div class="form-column">
        <label for="first_name">Prénom:</label>
        <input type="text" id="first_name" name="first_name" required value="<?php echo htmlspecialchars($individual['first_name'] ?? ''); ?>">
    </div>
    <div class="form-column">
        <label for="birth_date">Date de naissance:</label>
        <input type="date" id="birth_date" name="birth_date" value="<?php echo $individual['birth_date'] ?? ''; ?>">
    </div>
    <div class="form-column">
        <label for="birth_place">Lieu :</label>
        <input type="text" id="birth_place" name="birth_place" value="<?php echo htmlspecialchars($individual['birth_place'] ?? ''); ?>">
    </div>
    <div class="form-column" id="death_details" style="display: <?php echo ($individual['is_deceased'] == 1) ? 'block' : 'none'; ?>;">
        <label for="death_date">Date de décès :</label>
        <input type="date" id="death_date" name="death_date" value="<?php echo $individual['death_date'] ?? ''; ?>">
        <label for="death_place">Lieu :</label>
        <input type="text" id="death_place" name="death_place" value="<?php echo htmlspecialchars($individual['death_place'] ?? ''); ?>">
    </div>
    <div class="form-column">
        <label for="occupation">Profession :</label>
        <input type="text" id="occupation" name="occupation" value="<?php echo htmlspecialchars($individual['occupation'] ?? ''); ?>">
    </div>
    <div class="form-column">
        <label for="notes">Notes :</label>
        <textarea id="notes" name="notes"><?php echo htmlspecialchars($individual['notes'] ?? ''); ?></textarea>
    </div>
    <div class="form-column">
        <label for="marriage_date">Date de mariage:</label>
        <input type="date" id="marriage_date" name="marriage_date" value="<?php echo $individual['marriage_date'] ?? ''; ?>">
    </div>
    <div class="form-column">
        <label for="marriage_place">Lieu de mariage:</label>
        <input type="text" id="marriage_place" name="marriage_place" value="<?php echo htmlspecialchars($individual['marriage_place'] ?? ''); ?>">
    </div>
    <div class="form-actions">
        <button type="submit">Mettre à jour</button>
    </div>
</form>
<div id="message-container" class="message-container"></div>
<script>
    // Fonction pour convertir le texte en majuscules
    function convertToUpperCase() {
        // Récupère l'élément input par son ID
        let input = document.getElementById('last_name');
        // Convertit la valeur de l'input en majuscules
        input.value = input.value.toUpperCase();
    }

    // Ajoute un écouteur d'événement à l'élément avec l'ID 'status'
    document.getElementById('status').addEventListener('change', function () {
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
<script>
    // JavaScript pour afficher le message de succès ou d'erreur
    document.addEventListener('DOMContentLoaded', function() {
        var messageContainer = document.getElementById('message-container');
        var message = "<?php echo addslashes($message); ?>"; // PHP message avec échappement des guillemets

        // Vérifie si le message n'est pas vide
        if (message.trim() !== '') {
            // Crée un élément div pour afficher le message
            var messageDiv = document.createElement('div');
            messageDiv.className = 'message';
            messageDiv.textContent = message;

            // Ajoute le message à la div message-container
            messageContainer.appendChild(messageDiv);
        }
    });
</script>
</body>
>>>>>>> origin/main
</html>