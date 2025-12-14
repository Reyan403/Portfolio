<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - AdminPortfolio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body class="login-body">
    <div class="login-card">
        <h2>Admin Panel</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
                Identifiant ou mot de passe incorrect.
            </div>
        <?php endif; ?>
        <form action="traitement_login.php" method="POST">
            <div class="form-group">
                <label for="username">Identifiant</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Votre identifiant">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Votre mot de passe">
            </div>
            <button type="submit" class="btn-submit login-btn">Se connecter</button>
        </form>
        <a href="../index.php" class="back-link"><i class="fas fa-arrow-left"></i> Retour au site principal</a>
    </div>
</body>
</html>
