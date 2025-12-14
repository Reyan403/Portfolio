<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

require 'src/Model/db.php';
require 'src/Model/Projet.php';
require 'src/DAO/ProjetDAO.php';

use src\DAO\ProjetDAO;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    try {
        $projetDAO = new ProjetDAO($connexion);
        $projet = $projetDAO->findById($id);
        
        if ($projet) {
            $projetDAO->remove($projet); // supprime juste la base
        }
    } catch (\Exception $e) {
        $message = "Erreur de suppression";
        $status = "error";
    }
}

header("Location: index.php");
exit;
