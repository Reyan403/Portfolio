<?php
session_start();
require 'src/Model/db.php';
require 'src/Model/Login.php';
require 'src/DAO/LoginDAO.php';

use src\DAO\LoginDAO;

// Vérifier si la requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérifier les identifiants
    $loginDAO = new LoginDAO($connexion);
    $user = $loginDAO->checkLogin($username, $password);

    // Si les identifiants sont corrects, rediriger vers la page admin
    // Sinon, rediriger vers la page de connexion avec un message d'erreur
    if ($user) {
        $_SESSION['admin_id'] = $user->getId();
        $_SESSION['admin_user'] = $user->getUsername();
        header("Location: index.php");
        exit;
    } else {
        header("Location: login.php?error=1");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
