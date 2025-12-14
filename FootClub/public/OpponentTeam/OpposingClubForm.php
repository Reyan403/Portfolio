<?php
    require __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__ . '/../../src/Model/db.php';

    use DAO\OpposingClubDAO;
    use Service\OpposingClubFormValidate;
    use Model\OpposingClub;

    // Connexion à la DAO
    $opposingClubDAO = new OpposingClubDAO($connexion);

    $postData = [
        'address'=> '',
        'city'=> '',
    ];

    $errors = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        // Récupération des données du formulaire
        $postData = [
            'address' => trim($_POST['address'] ?? ''),
            'city'    => trim($_POST['city'] ?? ''),
        ];

        // Validation
        $form = new OpposingClubFormValidate();
        $form->champVide();
        $form->caracteresSpeciaux();
        $errors = $form->getErrors();

        // Si pas d’erreurs
        if(empty($errors))
        {
            $club = new OpposingClub(
                null,
                $postData['address'],
                $postData['city']
            );

            $opposingClubDAO->insert($club);

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