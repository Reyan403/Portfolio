<?php
    require __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__ . '/../../src/Model/db.php';

    use DAO\PlayerHasTeamDAO;
    use Model\PlayerHasTeam;
    use Model\Player;
    use Model\Team;

    // Initialisation du DAO
    $playerHasTeamDAO = new PlayerHasTeamDAO($connexion);

    // Vérification des paramètres
    if (isset($_GET['player_id']) && isset($_GET['team_id'])) {
        $playerId = (int) $_GET['player_id'];
        $teamId = (int) $_GET['team_id'];

        // On va chercher la relation précise
        $playerHasTeam = $playerHasTeamDAO->findById($playerId, $teamId);

        if ($playerHasTeam) {
            $playerHasTeamDAO->remove($playerHasTeam);
        }
    }

    // Retour à la page principale
    header("Location: ../index.php");
    exit;