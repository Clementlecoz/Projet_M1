<?php
// Connexion à la base de données
$host = "localhost"; // Serveur MySQL
$dbname = "projet_m1"; // Nom de la base de données
$username = "root"; // Utilisateur MySQL
$password = ""; // Mot de passe MySQL (laisser vide en local)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// 🔹 Étape 1 : Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 🔹 Étape 2 : Récupérer les données du formulaire
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT); // Hachage du mot de passe

    // 🔹 Étape 3 : Vérifier si l'utilisateur existe déjà
    $check = $pdo->prepare("SELECT * FROM utilisateur WHERE email = :email");
    $check->bindParam(':email', $email);
    $check->execute();

    if ($check->rowCount() > 0) {
        echo "❌ Cet email est déjà utilisé.";
    } else {
        // 🔹 Étape 4 : Insérer les données dans la base de données
        $sql = "INSERT INTO utilisateur (email, mot_de_passe) VALUES (:email, :mot_de_passe)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe);

        if ($stmt->execute()) {
            echo "✅ Utilisateur enregistré avec succès.";
            header("Location: index.html"); // Redirection après inscription
            exit();
        } else {
            echo "❌ Erreur lors de l'enregistrement.";
        }
    }
}
?>
