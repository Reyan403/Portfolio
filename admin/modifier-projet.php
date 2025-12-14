<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

require 'src/Model/db.php';
require 'src/Model/Projet.php';
require 'src/DAO/ProjetDAO.php';
require 'src/Enumeration/CategorieEnum.php';
require 'src/Service/Validation.php';

use src\Model\Projet;
use src\DAO\ProjetDAO;
use src\Enumeration\CategorieEnum;
use src\Service\Validation;

$targetDir = "C:/xampp/ghazz/htdocs/php/Portfolio/img-portfolio/";
$projetDAO = new ProjetDAO($connexion);

$projet = null;

if (isset($_GET['id'])) {
    $projet = $projetDAO->findById(intval($_GET['id']));
}

if (!$projet) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['title'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    
     // Handle technologies array -> string
    if (isset($_POST['technologies']) && is_array($_POST['technologies'])) {
        $technologies = implode(', ', $_POST['technologies']);
    } else {
        $technologies = '';
    }
    
    $lien = $_POST['link'];
    $categorie = $_POST['categorie'];

    try {
        \src\Service\Validation::validateProjetData($titre, $description, $categorie);
        $imageName = $projet->getImage(); // Par défaut on garde l'ancienne image

        // Si une nouvelle image est uploadée
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
            $imageName = \src\Service\Validation::validateImageUpload($_FILES["image"], $targetDir);
        }

        // Mettre à jour l'objet projet
        $projet->setTitre($titre);
        $projet->setDate($date);
        $projet->setDescription($description);
        $projet->setTechnologies($technologies);
        $projet->setLien($lien);
        $projet->setImage($imageName);
        $projet->setCategorie($categorie);

        $projetDAO->update($projet);
        $message = "Projet mis à jour avec succès !";
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
    <title>Modifier Projet - AdminPortfolio</title>
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
                <li><a href="ajout-projet.php"><i class="fas fa-plus-circle"></i> Ajouter un projet</a></li>
                <li><a href="../index.php"><i class="fas fa-external-link-alt"></i> Voir le site</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="header-admin">
                <div class="header-title">
                    <h4>Espace Administrateur</h4>
                    <h1>Modifier le Projet</h1>
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
                            <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($projet->getTitre()); ?>">
                        </div>
                        <div class="form-group">
                             <label for="date">Date de réalisation</label>
                             <input type="date" id="date" name="date" class="form-control" value="<?php echo htmlspecialchars($projet->getDate()); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea id="description" name="description" class="form-control"><?php echo htmlspecialchars($projet->getDescription()); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Technologies utilisées</label>
                         <div class="technologies-grid">
                            <?php 
                            $availableTechs = [
                                'HTML' => 'html.png',
                                'CSS' => 'css.png',
                                'JS' => 'js.png',
                                'PHP' => 'php.png',
                                'C#' => 'c-sharp.png',
                                'MySQL' => 'mysql (1).png',
                                'Symfony' => 'symfony.svg'
                            ];
                            $currentTechs = array_map('trim', explode(',', $projet->getTechnologies()));
                            
                            foreach ($availableTechs as $name => $img): 
                                $checked = in_array($name, $currentTechs) ? 'checked' : '';
                            ?>
                                <label class="tech-checkbox-label">
                                    <input type="checkbox" name="technologies[]" value="<?php echo $name; ?>" <?php echo $checked; ?>>
                                    <img src="../img-portfolio/<?php echo $img; ?>" alt="<?php echo $name; ?>" title="<?php echo $name; ?>">
                                    <span><?php echo $name; ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="link">Lien du projet</label>
                        <input type="text" id="link" name="link" class="form-control" value="<?php echo htmlspecialchars($projet->getLien()); ?>" placeholder="URL...">
                    </div>

                    <div class="form-group">
                        <label for="categorie">Type de projet <span class="text-danger">*</span></label>
                        <select id="categorie" name="categorie" class="form-control">
                            <?php foreach (CategorieEnum::cases() as $case): ?>
                                <option value="<?php echo $case->value; ?>" <?php echo ($projet->getCategorie() == $case->value) ? 'selected' : ''; ?>>
                                    <?php echo $case->value; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                         <label>Image du projet (Laisser vide pour garder l'actuelle)</label>
                         <div class="current-image-info">
                            Actuelle : <strong><?php echo htmlspecialchars($projet->getImage()); ?></strong>
                         </div>
                         <div class="file-upload-wrapper" onclick="document.getElementById('image').click()">
                             <input type="file" id="image" name="image" accept="image/*" style="display: none;" onchange="updateFileName(this)">
                             <i class="fas fa-cloud-upload-alt"></i>
                             <p>Cliquer pour changer l'image</p>
                             <small id="file-name" class="file-info-text">Nouveau fichier...</small>
                         </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                    <a href="index.php" class="btn-submit btn-cancel">Annuler</a>
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
