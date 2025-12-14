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

use src\Model\Projet;
use src\DAO\ProjetDAO;
use src\Enumeration\CategorieEnum;

$projetDAO = new ProjetDAO($connexion);
$projets = $projetDAO->getAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Projets - AdminPortfolio</title>
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
                <li><a href="index.php" class="active"><i class="fas fa-list"></i> Liste des projets</a></li>
                <li><a href="ajout-projet.php"><i class="fas fa-plus-circle"></i> Ajouter un projet</a></li>
                <li><a href="../index.php"><i class="fas fa-external-link-alt"></i> Voir le site</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="header-admin">
                <div class="header-title">
                    <h4>Espace Administrateur</h4>
                    <h1>Mes Projets</h1>
                </div>
                <a href="ajout-projet.php" class="btn-submit btn-submit-small">
                    <i class="fas fa-plus"></i> Nouveau
                </a>
            </header>

            <div class="form-card form-card-flush">
                <table class="projects-table">
                    <thead>
                        <tr>
                            <th width="10%">Image</th>
                            <th width="20%">Projet</th>
                            <th width="30%">Description</th>
                            <th width="10%">Catégorie</th>
                            <th width="15%">Technos</th>
                            <th width="15%">Lien</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projets as $projet): ?>
                        <tr>
                            <td><img src="../img-portfolio/<?php echo htmlspecialchars($projet->getImage()); ?>" alt="Img" class="project-thumb" onerror="this.src='https://via.placeholder.com/60'"></td>
                            <td>
                                <span class="project-title"><?php echo htmlspecialchars($projet->getTitre()); ?></span>
                                <span class="project-date"><?php echo htmlspecialchars($projet->getDate()); ?></span>
                            </td>
                            <td><?php echo htmlspecialchars(substr($projet->getDescription(), 0, 50)) . '...'; ?></td>
                            <td>
                                <?php 
                                    $catValue = $projet->getCategorie();
                                    $badgeClass = 'status-badge';
                                    echo '<span class="'.$badgeClass.'">'.htmlspecialchars($catValue ?? 'Aucune').'</span>';
                                ?>
                            </td>
                            <td><span class="status-badge"><?php echo htmlspecialchars($projet->getTechnologies()); ?></span></td>
                            <td><a href="<?php echo htmlspecialchars($projet->getLien()); ?>" target="_blank" class="link-primary">Voir</a></td>
                            <td>
                                <a href="modifier-projet.php?id=<?php echo $projet->getId(); ?>" class="action-btn btn-edit" title="Modifier"><i class="fas fa-pen"></i></a>
                                <a href="supprimer-projet.php?id=<?php echo $projet->getId(); ?>" class="action-btn btn-delete" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($projets)): ?>
                        <tr>
                            <td colspan="6" class="empty-table-message">Aucun projet trouvé. Commençez par en ajouter un !</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
