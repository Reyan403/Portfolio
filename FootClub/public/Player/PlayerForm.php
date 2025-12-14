<?php
    require __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__ . '/../../src/Model/db.php';

    use DAO\PlayerDAO;
    use Service\PlayerFormValidate;
    use Model\Player;

    // DAO
    $playerDAO = new PlayerDAO($connexion);

    // Initialisation des valeurs 
    $postData = [
        'firstname' => '',
        'lastname'  => '',
        'birthdate' => '',
    ];

    $errors = [];

    // Si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $postData = [
            'firstname' => trim($_POST['firstname'] ?? ''),
            'lastname'  => trim($_POST['lastname'] ?? ''),
            'birthdate' => $_POST['birthdate'] ?? '',
        ];

        // Validation
        $form = new PlayerFormValidate();
        $form->champVide();
        $form->caracteresSpeciaux();
        $errors = $form->getErrors();

        // S'il n'y a pas d'erreurs
        if (empty($errors)) {
            $player = new Player(
                null,
                $postData['firstname'],
                $postData['lastname'],
                new \DateTime($postData['birthdate']),
                $postData['picture'] ?? null
            );

            $playerDAO->insert($player);

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
    <title>FootClub - Ajouter un joueur</title>
</head>

<body>
<h1>Ajouter un joueur</h1>

<form method="post" action="#">
    <div>
        <label for="firstname">Prénom :</label>
        <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($postData['firstname']) ?>">
        <?php if (!empty($errors['firstname'])): ?>
            <p style="color:red"><?= htmlspecialchars($errors['firstname']) ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label for="lastname">Nom :</label>
        <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($postData['lastname']) ?>">
        <?php if (!empty($errors['lastname'])): ?>
            <p style="color:red"><?= htmlspecialchars($errors['lastname']) ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label for="birthdate">Date de naissance :</label>
        <input type="date" id="birthdate" name="birthdate" value="<?= htmlspecialchars($postData['birthdate']) ?>">
        <?php if (!empty($errors['birthdate'])): ?>
            <p style="color:red"><?= htmlspecialchars($errors['birthdate']) ?></p>
        <?php endif; ?>
    </div>

    <br>
    <input type="submit" value="Enregistrer">
</form>

</body>
</html>
