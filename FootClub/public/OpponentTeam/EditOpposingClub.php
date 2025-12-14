<?php
    require __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__ . '/../../src/Model/db.php';

    use DAO\OpposingClubDAO;
    use Service\OpposingClubFormValidate;

    $opposingClubDAO = new OpposingClubDAO($connexion);
    $form = new OpposingClubFormValidate();

    // Récupérer l'id passé dans l'URL
    $id = $_GET['id'] ?? null;
    if (!$id) {
        die("Equipe non spécifié !");
    }

    // Récupérer l'équipe existant
    $opposingClub = $opposingClubDAO->findById((int)$id);
    if (!$opposingClub) {
        die("Equipe introuvable !");
    }

    // Pré-remplir le formulaire avec les valeurs existantes
    $postData = [
        'city' => $opposingClub->getCity(),
        'address'  => $opposingClub->getAddress()
    ];

    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postData = [
            'city' => $_POST['city'],
            'address'  => $_POST['address']
        ];

        // Validation avec ta classe simple
        $form->champVide();
        $form->caracteresSpeciaux();
        $errors = $form->getErrors();

        if (empty($errors)) {
            // Mettre à jour l'équipe
            $opposingClub->setCity($postData['city']);
            $opposingClub->setAddress($postData['address']);

            $opposingClubDAO->update($opposingClub);

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
    <title>FootClub</title>
</head>
<body>
    <section>

    <h1>
        Formulaire d'ajout d'équipe adverse
    </h1>
        <form action="#" method="POST">
            <label for="city">Ville :</label>
            <input type="text" id="city" name="city" value="<?= htmlspecialchars($postData['city']) ?>"><br>
            <?php if (!empty($errors['city'])): ?>
                <p style="color:red"><?= htmlspecialchars($errors['city']) ?></p>
            <?php endif; ?>

            <label for="address">Adresse :</label>
            <input type="text" id="address" name="address" value="<?= htmlspecialchars($postData['address']) ?>"><br>
            <?php if (!empty($errors['address'])): ?>
                <p style="color:red"><?= htmlspecialchars($errors['address']) ?></p>
            <?php endif; ?>
                <br>
            <input type="submit" value="Enregistrer">
        </form>
    </section>
</body>
</html>