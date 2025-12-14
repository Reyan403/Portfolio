<?php
    require __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__ . '/../../src/Model/db.php';

    use DAO\PlayerDAO;

    $playerDAO = new PlayerDAO($connexion);

    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];
        $player = $playerDAO->findById($id);

        if ($player) {
            $playerDAO->remove($player);
        }
    }

    header("Location: ../index.php");
    exit;
