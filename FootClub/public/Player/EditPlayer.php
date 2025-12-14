<?php
    require __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__ . '/../../src/Model/db.php';

    use DAO\PlayerDAO;
    use Service\PlayerFormValidate;

    $playerDAO = new PlayerDAO($connexion);
    $form = new PlayerFormValidate();

    // Récupérer l'id passé dans l'URL
    $id = $_GET['id'] ?? null;
    if (!$id) {
        die("Joueur non spécifié !");
    }

    // Récupérer le joueur existant
    $player = $playerDAO->findById((int)$id);
    if (!$player) {
        die("Joueur introuvable !");
    }

    // Pré-remplir le formulaire avec les valeurs existantes
    $postData = [
        'firstname' => $player->getFirstname(),
        'lastname'  => $player->getLastname(),
        'birthdate' => $player->getBirthdate()->format('Y-m-d')
    ];

    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postData = [
            'firstname' => $_POST['firstname'],
            'lastname'  => $_POST['lastname'],
            'birthdate' => $_POST['birthdate']
        ];

        // Validation avec ta classe simple
        $form->champVide();
        $form->caracteresSpeciaux();
        $errors = $form->getErrors();

        if (empty($errors)) {
            // Mettre à jour le joueur
            $player->setFirstname($postData['firstname']);
            $player->setLastname($postData['lastname']);
            $player->setBirthdate(new \DateTime($postData['birthdate']));

            $playerDAO->update($player);

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
    <title>Modifier un joueur</title>
</head>

<body>
<h1>Éditer un joueur</h1>

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
