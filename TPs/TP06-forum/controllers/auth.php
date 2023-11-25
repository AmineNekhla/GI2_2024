<?php

include('../models/db.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "Tous les champs sont obligatoires.";
        header("Location:../view/login.php?error=Tous les champs sont obligatoires");
        exit();
    }

    $user = getUserByEmail($email);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user'] = array(
            'nom' => $user['nom'],
            'email' => $user['email']
        );

        header("Location:../view/home.php");
        exit();
    } else {

        header("Location:../view/login.php?error=Mot de passe incorrect");
        exit();
    }
} else {
    echo "Erreur : méthode non autorisée.";
}
?>
