<?php
    require __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__ . '/../../src/Model/db.php';

    use DAO\TeamDAO;
    use Service\TeamFormValidate;
    use Model\Team;

    // DAO
    $teamDAO = new TeamDAO($connexion);

    // Valeurs par défaut
    $postData = [
        'name' => ''
    ];

    $errors = [];

    // Si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $postData = [
            'name' => trim($_POST['name'] ?? '')
        ];

        // Validation
        $form = new TeamFormValidate();
        $form->champVide();
        $form->caracteresSpeciaux();
        $errors = $form->getErrors();

        // S'il n'y a pas d'erreurs
        if (empty($errors)) {
            $team = new Team(
                null,
                $postData['name'],
            );

            $teamDAO->insert($team);

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
        Formulaire d'ajout d'équipe
    </h1>
        <form action="#" method="POST">
            <label>Nom :</label>
            <input type="text" name="name" value="<?= htmlspecialchars($postData['name']) ?>"><br>
            <?php if (!empty($errors['name'])): ?>
                <p style="color:red"><?= htmlspecialchars($errors['name']) ?></p>
            <?php endif; ?>
            <br>
            <input type="submit" value="Enregistrer">
        </form>
    </section>
</body>
</html>