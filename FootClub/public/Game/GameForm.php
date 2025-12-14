<?php
    require __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__ . '/../../src/Model/db.php';

    use DAO\GameDAO;
    use DAO\TeamDAO;
    use DAO\OpposingClubDAO;
    use Service\GameFormValidate;
    use Model\Game;

    // --- Initialisation des DAO ---
    $gameDAO = new GameDAO($connexion);
    $teamDAO = new TeamDAO($connexion);
    $opposingClubDAO = new OpposingClubDAO($connexion);

    // --- Récupération des équipes ---
    $teams = $teamDAO->getAll();
    $opposingClubs = $opposingClubDAO->getAll();

    // --- Données du formulaire par défaut ---
    $postData = [
        'teamScore' => '',
        'opponentScore' => '',
        'date' => '',
        'city' => '',
        'teamMatch' => '',
        'opponentClubMatch' => ''
    ];

    $errors = [];

    // --- Traitement du formulaire ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $postData = [
            'teamScore' => trim($_POST['teamScore'] ?? ''),
            'opponentScore' => trim($_POST['opponentScore'] ?? ''),
            'date' => trim($_POST['date'] ?? ''),
            'city' => trim($_POST['city'] ?? ''),
            'teamMatch' => trim($_POST['teamMatch'] ?? ''),
            'opponentClubMatch' => trim($_POST['opponentClubMatch'] ?? '')
        ];

        // Validation des données
        $form = new GameFormValidate();
        $form->champVide($postData);
        $form->caracteresSpeciaux($postData);
        $errors = $form->getErrors();

        // Si aucune erreur, on insère en base
        if (empty($errors)) {
            $team = $teamDAO->findById((int)$postData['teamMatch']);
            $opposingClub = $opposingClubDAO->findById((int)$postData['opponentClubMatch']);

            $game = new Game(
                null,
                new \DateTime($postData['date']),
                $postData['city'],
                (int)$postData['teamScore'],
                (int)$postData['opponentScore'],
                $team,
                $opposingClub
            );

            $gameDAO->insert($game);

            header("Location: ../index.php");
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Formulaire des matchs</title>
</head>
<body>
    <h1>Formulaire des matchs</h1>

    <form method="post" action="">
        <div>
            <label for="teamScore">Score de l'équipe :</label>
            <input type="number" id="teamScore" name="teamScore"
                   value="<?= htmlspecialchars($postData['teamScore']) ?>">
            <?php if (!empty($errors['teamScore'])): ?>
                <p style="color:red"><?= htmlspecialchars($errors['teamScore']) ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="opponentScore">Score de l'équipe adverse :</label>
            <input type="number" id="opponentScore" name="opponentScore"
                   value="<?= htmlspecialchars($postData['opponentScore']) ?>">
            <?php if (!empty($errors['opponentScore'])): ?>
                <p style="color:red"><?= htmlspecialchars($errors['opponentScore']) ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="date">Date du match :</label>
            <input type="date" id="date" name="date"
                   value="<?= htmlspecialchars($postData['date']) ?>">
            <?php if (!empty($errors['date'])): ?>
                <p style="color:red"><?= htmlspecialchars($errors['date']) ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="city">Ville du match :</label>
            <input type="text" id="city" name="city"
                   value="<?= htmlspecialchars($postData['city']) ?>">
            <?php if (!empty($errors['city'])): ?>
                <p style="color:red"><?= htmlspecialchars($errors['city']) ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="teamMatch">Équipe :</label>
            <select name="teamMatch" id="teamMatch">
                <option value="">--- Sélectionnez l'équipe ---</option>
                <?php foreach ($teams as $team): ?>
                    <option 
                        value="<?= htmlspecialchars($team->getId()) ?>"
                        <?= ($postData['teamMatch'] == $team->getId()) ? 'selected' : '' ?>>
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
                <?php foreach ($opposingClubs as $opposingClub): ?>
                    <option 
                        value="<?= htmlspecialchars($opposingClub->getId()) ?>"
                        <?= ($postData['opponentClubMatch'] == $opposingClub->getId()) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($opposingClub->getCity()) ?>
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
