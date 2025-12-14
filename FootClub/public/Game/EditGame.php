<?php
require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Model/db.php';

use DAO\GameDAO;
use DAO\OpposingClubDAO;
use DAO\TeamDAO;
use Service\GameFormValidate;

$gameDAO = new GameDAO($connexion);
$teamDAO = new TeamDAO($connexion);
$opposingClubDAO = new OpposingClubDAO($connexion);
$form = new GameFormValidate();

// Vérifier ID du match
if (!isset($_GET['id'])) {
    header("Location: ../index.php");
    exit;
}

$id = (int) $_GET['id'];
$game = $gameDAO->findById($id);

if (!$game) {
    header("Location: ../index.php");
    exit;
}

$errors = [];
$postData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération des champs
    $postData = [
        'teamScore'          => $_POST['teamScore'] ?? '',
        'opponentScore'      => $_POST['opponentScore'] ?? '',
        'date'               => $_POST['date'] ?? '',
        'city'               => $_POST['city'] ?? '',
        'teamMatch'          => $_POST['teamMatch'] ?? '',
        'opponentClubMatch'  => $_POST['opponentClubMatch'] ?? ''
    ];

    // --- Validation ---
    $form->champVide();
    $form->caracteresSpeciaux();
    $errors = $form->getErrors();

    // Si aucune erreur : mise à jour du match
    if (empty($errors)) {

        $team = $teamDAO->findById((int)$postData['teamMatch']);
        $opposingClub = $opposingClubDAO->findById((int)$postData['opponentClubMatch']);

        if (!$team || !$opposingClub) {
            $errors['general'] = "Erreur : équipe ou club adverse introuvable.";
        } else {
            $game->setTeamScore((int)$postData['teamScore']);
            $game->setOpponentScore((int)$postData['opponentScore']);
            $game->setDate(new \DateTime($postData['date']));
            $game->setCity($postData['city']);
            $game->setTeam($team);
            $game->setOpposingClub($opposingClub);

            $gameDAO->update($game);

            header("Location: ../index.php");
            exit;
        }
    }

} else {
    // Pré-remplissage
    $postData = [
        'teamScore'          => $game->getTeamScore(),
        'opponentScore'      => $game->getOpponentScore(),
        'date'               => $game->getDate()->format('Y-m-d'),
        'city'               => $game->getCity(),
        'teamMatch'          => $game->getTeam()->getId(),
        'opposingClubMatch'  => $game->getOpposingClub()->getId(),
    ];
}

// Charger les listes
$teams = $teamDAO->getAll();
$opposingClubs = $opposingClubDAO->getAll();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Modifer un match</title>
</head>
<body>
    <h1>Modifier un match</h1>
    <form action="" method="POST">
         
    <div>
        <label for="teamScore">Score de l'équipe :</label>
        <input type="number" id="teamScore" name="teamScore"
               value="<?= htmlspecialchars($postData['teamScore'] ?? $game->getTeamScore()) ?>">
        <?php if (!empty($errors['teamScore'])): ?>
            <p style="color:red"><?= htmlspecialchars($errors['teamScore']) ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label for="opponentScore">Score de l'équipe adverse :</label>
        <input type="number" id="opponentScore" name="opponentScore"
               value="<?= htmlspecialchars($postData['opponentScore'] ?? $game->getOpponentScore()) ?>">
        <?php if (!empty($errors['opponentScore'])): ?>
            <p style="color:red"><?= htmlspecialchars($errors['opponentScore']) ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label for="date">Date du match :</label>
        <input type="date" id="date" name="date"
               value="<?= htmlspecialchars(($postData['date'] ?? $game->getDate()->format('Y-m-d'))) ?>">
        <?php if (!empty($errors['date'])): ?>
            <p style="color:red"><?= htmlspecialchars($errors['date']) ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label for="city">Ville du match :</label>
        <input type="text" id="city" name="city"
               value="<?= htmlspecialchars($postData['city'] ?? $game->getCity()) ?>">
        <?php if (!empty($errors['city'])): ?>
            <p style="color:red"><?= htmlspecialchars($errors['city']) ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label for="teamMatch">Équipe :</label>
        <select name="teamMatch" id="teamMatch">
            <option value="">--- Sélectionnez l'équipe ---</option>

            <?php foreach ($teams as $team): ?>
                <option value="<?= htmlspecialchars($team->getId()) ?>"
                    <?= ($postData['teamMatch'] ?? $game->getTeam()->getId()) == $team->getId() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($team->getName()) ?>
                </option>
            <?php endforeach; ?>

        </select>
        <?php if (!empty($errors['teamMatch'])): ?>
            <p style="color:red"><?= htmlspecialchars($errors['teamMatch']) ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label for="opponentClubMatch">Équipe adverse :</label>
        <select name="opponentClubMatch" id="opponentClubMatch">
            <option value="">--- Sélectionnez l'équipe adverse ---</option>

            <?php foreach ($opposingClubs as $oc): ?>
                <option value="<?= htmlspecialchars($oc->getId()) ?>"
                    <?= ($postData['opponentClubMatch'] ?? $game->getOpposingClub()->getId()) == $oc->getId() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($oc->getCity()) ?>
                </option>
            <?php endforeach; ?>

        </select>
        <?php if (!empty($errors['opponentClubMatch'])): ?>
            <p style="color:red"><?= htmlspecialchars($errors['opponentClubMatch']) ?></p>
        <?php endif; ?>
    </div>

    <br>

    <input type="submit" value="Enregistrer">

    </form>
</body>
</html>