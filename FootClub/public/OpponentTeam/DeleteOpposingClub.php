<?php
    require __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__ . '/../../src/Model/db.php';

    use DAO\OpposingClubDAO;

    $opposingClubDAO = new OpposingClubDAO($connexion);

    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];
        $opposingClub = $opposingClubDAO->findById($id);

        if ($opposingClub) {
            $opposingClubDAO->remove($opposingClub);
        }
    }

    header("Location: ../index.php");
    exit;
