<?php
session_start();

// Vérification de la session admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Chargement des dépendances
require __DIR__ . '/../src/Model/db.php';
require __DIR__ . '/../src/Model/Projet.php';
require __DIR__ . '/../src/DAO/ProjetDAO.php';
require __DIR__ . '/../src/Enumeration/CategorieEnum.php';
require __DIR__ . '/../src/Service/Validation.php';

// Configuration globale
$imgPortfolioDir = realpath(__DIR__ . '/../../img-portfolio/') . '/';

// Liste des technologies disponibles pour les projets
$availableTechs = [
    'HTML' => 'html.png',
    'CSS' => 'css.png',
    'JS' => 'js.png',
    'PHP' => 'php.png',
    'C#' => 'c-sharp.png',
    'MySQL' => 'mysql (1).png',
    'Symfony' => 'symfony.svg'
];
