<?php

include('../models/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($nom) || empty($email) || empty($password)) {
        echo "Tous les champs sont obligatoires.";
    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        if (adduser($nom, $email, $hashed_password)) {
            header("location: ../view/login.php");
        } else {
            echo "Erreur lors de l'ajout de l'utilisateur.";
        }
    }
} else {
    echo "Erreur : méthode non autorisée.";
}

?>
