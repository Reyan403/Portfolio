<?php
require 'includes/admin-init.php';

use src\Model\Projet;
use src\DAO\ProjetDAO;
use src\Enumeration\CategorieEnum;
use src\Service\Validation;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['title'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    
    // Gestion des technologies (tableau vers chaîne)
    $technologies = isset($_POST['technologies']) && is_array($_POST['technologies']) 
        ? implode(', ', $_POST['technologies']) 
        : '';

    $lien = $_POST['link'];
    $categorie = $_POST['categorie'];

    try {
        // 1. Validation des données textuelles
        Validation::validateProjetData($titre, $description, $categorie);
        
        // 2. Validation et upload de l'image
        $fileName = Validation::validateImageUpload($_FILES["image"], $imgPortfolioDir);

        // 3. Création et sauvegarde du projet
        $projet = new Projet(null, $titre, $date, $description, $technologies, $lien, $fileName, $categorie);
        $projetDAO = new ProjetDAO($connexion);
        $projetDAO->insert($projet);

        $message = "Le projet a été ajouté avec succès !";
        $status = "success";
    } catch (\Exception $e) {
        $message = "Erreur : " . $e->getMessage();
        $status = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Projet - AdminPortfolio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-container">
        <nav class="sidebar">
            <div class="logo-area">
                <h2>AdminPanel</h2>
            </div>
            <ul class="nav-links">
                <li><a href="index.php"><i class="fas fa-list"></i> Liste des projets</a></li>
                <li><a href="ajout-projet.php" class="active"><i class="fas fa-plus-circle"></i> Ajouter un projet</a></li>
                <li><a href="../index.php"><i class="fas fa-external-link-alt"></i> Voir le site</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="header-admin">
                <div class="header-title">
                    <h4>Espace Administrateur</h4>
                    <h1>Nouveau Projet</h1>
                </div>
            </header>

            <?php if(!empty($message)): ?>
            <div class="alert-message <?php echo ($status == 'success') ? 'alert-success' : 'alert-error'; ?>">
                <?php echo $message; ?>
            </div>
            <?php endif; ?>

            <div class="form-card">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row-group">
                        <div class="form-group">
                            <label for="title">Titre du projet <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control" placeholder="Nom du projet">
                        </div>
                        <div class="form-group">
                             <label for="date">Date de réalisation</label>
                             <input type="date" id="date" name="date" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="categorie">Type de projet <span class="text-danger">*</span></label>
                        <select id="categorie" name="categorie" class="form-control">
                            <option value="">Sélectionner un type...</option>
                            <?php foreach (CategorieEnum::cases() as $case): ?>
                                <option value="<?php echo $case->value; ?>">
                                    <?php echo $case->value; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea id="description" name="description" class="form-control" placeholder="Détails du projet..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Technologies utilisées</label>
                        <div class="technologies-grid">
                            <?php foreach ($availableTechs as $name => $img): ?>
                                <label class="tech-checkbox-label">
                                    <input type="checkbox" name="technologies[]" value="<?php echo $name; ?>">
                                    <img src="../img-portfolio/<?php echo $img; ?>" alt="<?php echo $name; ?>" title="<?php echo $name; ?>">
                                    <span><?php echo $name; ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="link">Lien du projet</label>
                        <input type="text" id="link" name="link" class="form-control" placeholder="Lien vers le projet (ex: https://mon-site.com ou /projets/mon-projet)">
                    </div>

                    <div class="form-group">
                         <label>Image du projet</label>
                         <div class="file-upload-wrapper" onclick="document.getElementById('image').click()">
                             <input type="file" id="image" name="image" accept="image/*" style="display: none;" onchange="updateFileName(this)">
                             <i class="fas fa-cloud-upload-alt"></i>
                             <p>Cliquer pour uploader</p>
                             <small id="file-name" class="file-info-text">Sera sauvegardé dans /img-portfolio</small>
                         </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Enregistrer le projet
                    </button>
                </form>
            </div>
        </main>
    </div>

    <script>
        function updateFileName(input) {
            const fileNameSpan = document.getElementById('file-name');
            if (input.files && input.files.length > 0) {
                fileNameSpan.textContent = "Fichier : " + input.files[0].name;
                fileNameSpan.classList.add('file-info-active');
            }
        }
    </script>
</body>
</html>
