<?php
    require __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__ . '/../../src/Model/db.php';

    use DAO\TeamDAO;
    use Service\TeamFormValidate;

    $teamDAO = new TeamDAO($connexion);
    $form = new TeamFormValidate();

    // Récupérer l'id passé dans l'URL
    $id = $_GET['id'] ?? null;
    if (!$id) {
        die("Equipe non spécifié !");
    }

    // Récupérer le Equipe existant
    $team = $teamDAO->findById((int)$id);
    if (!$team) {
        die("Equipe introuvable !");                         
    }

    // Pré-remplir le formulaire avec les valeurs existantes
    $postData = [
        'name' => $team->getname()
    ];

    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postData = [
            'name' => $_POST['name'] ?? ''
        ];

        // Validation avec ta classe simple
        $form->champVide();
        $form->caracteresSpeciaux();
        $errors = $form->getErrors();

        if (empty($errors)) {
            // Mettre à jour l'équipe
            $team->setname($postData['name']);

            $teamDAO->update($team);

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
    <title>Modifier une équipe</title>
</head>

<body>
    
<h1>Éditer une équipe</h1>

<form method="post" action="#">
    <div>
        <label for="name">Prénom :</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($postData['name']) ?>">
        <?php if (!empty($errors['name'])): ?>
            <p style="color:red"><?= htmlspecialchars($errors['name']) ?></p>
        <?php endif; ?>
    </div>

    <br>
    <input type="submit" value="Enregistrer">
</form>

</body>
</html>