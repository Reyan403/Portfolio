<?php
    require __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__ . '/../../src/Model/db.php';

    use DAO\TeamDAO;

    $teamDAO = new TeamDAO($connexion);

    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];
        $team = $teamDAO->findById($id);

        if ($team) {
            $teamDAO->remove($team);
        }
    }

    header("Location: ../index.php");
    exit;
