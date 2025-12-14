<?php
    require __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__ . '/../../src/Model/db.php';

    use DAO\PlayerDAO;
    use DAO\TeamDAO;
    use DAO\PlayerHasTeamDAO;
    use Service\PlayerHasTeamFormValidate;
    use Model\PlayerHasTeam;
    use Enumeration\PlayerRole;

    $playerDAO = new PlayerDAO($connexion);
    $teamDAO = new TeamDAO($connexion);

    $players = $playerDAO->getAll(); 
    $teams = $teamDAO->getAll();    

    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $playerId = $_POST['player'];
        $teamId = $_POST['team'];
        $roleValue = $_POST['role'];

        $form = new PlayerHasTeamFormValidate();
        $form->champVide();
        $errors = $form->getErrors();

        if ($playerId && $teamId && $roleValue) {
            $player = $playerDAO->findById((int)$playerId);
            $team = $teamDAO->findById((int)$teamId);
            $role = \Enumeration\PlayerRole::From($roleValue);

            $playerHasTeam = new PlayerHasTeam($player, $team, $role);
            $playerHasTeamDAO = new \DAO\PlayerHasTeamDAO($connexion);
            $playerHasTeamDAO->insert($playerHasTeam);

            header("Location: ../index.php");
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Ajout de rôle</title>
</head>
<body>
    <form action="#" method="POST">
        <label for="player">Joueur :</label>
        <select name="player" id="player">
            <option value="">--- Selectionner un joueur ---</option>
                <?php foreach ($players as $player): ?>
                    <option value="<?= htmlspecialchars($player->getId()) ?>">
                        <?= htmlspecialchars($player->getFirstname(). ' ' . $player->getLastname())?>
                    </option>
                <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['player'])): ?>
            <p style="color:red"><?= htmlspecialchars($errors['player']) ?></p>
        <?php endif; ?>

        <br><br>

        <label for="team">Equipe: </label>
        <select name="team" id="team">
            <option value="">--- Selectionner une équipe ---</option>
                <?php foreach($teams as $team): ?>
                    <option value="<?= htmlspecialchars($team->getId()) ?>">
                        <?= htmlspecialchars($team->getName())?>
                    </option>
                <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['team'])): ?>
            <p style="color:red"><?= htmlspecialchars($errors['team']) ?></p>
        <?php endif; ?>

        <br><br>

        <label for="role">Rôle :</label>
        <select name="role" id="role">
            <option value="">--- Selectionner un rôle</option>
                <?php foreach(PlayerRole::cases() as $role): ?>
                    <option value="<?= $role->value ?>">
                        <?= htmlspecialchars($role->value) ?>
                    </option>
                <?php endforeach; ?>
        </select>
         <?php if (!empty($errors['role'])): ?>
            <p style="color:red"><?= htmlspecialchars($errors['role']) ?></p>
        <?php endif; ?>

        <br><br>

        <input type="submit" value="Enregistrer">
    </form>
</body>
</html>