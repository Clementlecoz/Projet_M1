<?php

$user = 'root';  
$pass = '';   
  

try {
    $db = new PDO('mysql:host=localhost;dbname=projet_m1', $user, $pass);
    echo " Connexion reussie à la base de données.";
} catch (PDOException $e) {
    echo " Erreur : " . $e->getMessage();
    die();
}
?>
