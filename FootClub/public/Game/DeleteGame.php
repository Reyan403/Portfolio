<?php 
require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Model/db.php';

use DAO\GameDAO;

$gameDAO = new GameDAO($connexion);

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $game = $gameDAO->findById($id);

    if ($game) {
        $gameDAO->remove($game);
    }
}

header("Location: ../index.php");
    exit;
?>