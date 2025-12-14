<?php
require __DIR__ . '/../admin/src/Model/db.php';
require __DIR__ . '/../admin/src/Model/Projet.php';
require __DIR__ . '/../admin/src/DAO/ProjetDAO.php';
require __DIR__ . '/../admin/src/Enumeration/CategorieEnum.php';

use src\DAO\ProjetDAO;

// Récupération des projets
$projetDAO = new ProjetDAO($connexion);
$projets = $projetDAO->getAll();

// Gestion des classes CSS pour les projets
$numberClasses = [
    'first', 'second', 'third', 'fourth', 'five', 
    'six', 'seven', 'eight', 'nine', 'ten', 
    'eleven', 'twelve', 'thirteen', 'fourteen', 
    'fifteen', 'sixteen', 'seventeen', 'eighteen', 
    'nineteen', 'twenty'
];

/**
 * Retourne la classe CSS correspondant à la catégorie du projet
 */
function getCategoryClass($categorie) {
    if (!$categorie) return 'scolaire'; 
    return match($categorie) {
        'Projet encadré (Scolaire)' => 'scolaire',
        'Mission de stage' => 'stage',
        'Projet personnel' => 'personnel',
        default => 'scolaire'
    };
}

/**
 * Formate une date YYYY-MM-DD en "Mois Année" (ex: Novembre 2025)
 */
function formatDateFr($dateStr) {
    if (!$dateStr) return '';
    $months = [
        '01' => 'Janvier', '02' => 'Février', '03' => 'Mars', '04' => 'Avril',
        '05' => 'Mai', '06' => 'Juin', '07' => 'Juillet', '08' => 'Août',
        '09' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre'
    ];
    $timestamp = strtotime($dateStr);
    if (!$timestamp) return $dateStr;
    $month = date('m', $timestamp);
    $year = date('Y', $timestamp);
    return (isset($months[$month]) ? $months[$month] : '') . ' ' . $year;
}

/**
 * Retourne le chemin de l'image correspondant à une technologie
 */
function getTechImage($techName) {
    $techName = strtolower(trim($techName));
    $map = [
        'html' => 'html.png',
        'css' => 'css.png', 
        'js' => 'js.png',
        'javascript' => 'js.png',
        'php' => 'php.png',
        'c#' => 'c-sharp.png',
        'csharp' => 'c-sharp.png',
        'symfony' => 'symfony.svg',
        'mysql' => 'mysql (1).png'
    ];
    return isset($map[$techName]) ? './img-portfolio/' . $map[$techName] : null;
}