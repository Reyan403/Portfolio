<?php
require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Model/db.php';

use DAO\PlayerDAO;
use DAO\TeamDAO;
use DAO\PlayerHasTeamDAO;
use Model\Player;
use Model\Team;
use Model\PlayerHasTeam;
use Enumeration\PlayerRole;
use Service\PlayerHasTeamFormValidate;

// Instanciation des DAO
$playerDAO = new PlayerDAO($connexion);
$teamDAO = new TeamDAO($connexion);
$playerHasTeamDAO = new PlayerHasTeamDAO($connexion);
$form = new PlayerHasTeamFormValidate();

// Récupérer l'ID du joueur passé en GET
$playerId = $_GET['player_id'] ?? null;
if (!$playerId) {
    die("Joueur non spécifié !");
}

$player = $playerDAO->findById((int)$playerId);
if (!$player) {
    die("Joueur introuvable !");
}

// Récupérer les équipes pour la liste déroulante
$teams = $teamDAO->getAll();

// Pré-remplir le formulaire si déjà associé
$teamId = $_GET['team_id'] ?? '';
$existingAssoc = null;
$roleValue = '';

if ($teamId) {
    $existingAssoc = $playerHasTeamDAO->findById((int)$playerId, (int)$teamId);
    if ($existingAssoc) {
        $teamId = $existingAssoc['team_id'];
        $roleValue = $existingAssoc['role'];
    }
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = [
        'player' => $playerId,
        'team'   => $_POST['team'] ?? '',
        'role'   => $_POST['role'] ?? ''
    ];

    $form->champVide();
    $errors = $form->getErrors();

    if (empty($errors)) {
        $team = new Team((int)$postData['team'], '');
        $role = PlayerRole::from($postData['role']);
        $playerHasTeam = new PlayerHasTeam($player, $team, $role);

        if ($existingAssoc) {
            $playerHasTeamDAO->updateTeamAndRole($playerHasTeam, $existingAssoc['team_id']);
        } else {
            $playerHasTeamDAO->insert($playerHasTeam);
        }

        header("Location: ../index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Éditer Joueur/Équipe</title>
</head>
<body>
<h1>Modifier les équipes et rôles du joueur</h1>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST">
    <label for="player">Joueur :</label>
    <input type="text" name="player" id="player" value="<?= htmlspecialchars($player->getFirstname() . ' ' . $player->getLastname()) ?>" readonly ><br><br>

    <label for="team">Équipe :</label>
    <select name="team" id="team" required>
        <option value="">--Choisir une équipe--</option>
        <?php foreach ($teams as $team): ?>
            <option value="<?= $team->getId() ?>" <?= ($teamId == $team->getId()) ? 'selected' : '' ?>>
                <?= htmlspecialchars($team->getName()) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="role">Rôle :</label>
    <select name="role" id="role" required>
        <option value="">--Choisir un rôle--</option>
        <?php foreach (PlayerRole::cases() as $r): ?>
            <option value="<?= $r->value ?>" <?= ($roleValue == $r->value) ? 'selected' : '' ?>>
                <?= htmlspecialchars($r->value) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <input type="submit" value="Enregistrer">
</form>
</body>
</html>
