<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Portfolio de Reyan – Développeur Web Junior à Saint Vincent</title>
    <meta name="description" content="Portfolio de Reyan, développeur web junior. Projets, compétences HTML CSS PHP et contact.">
    <meta name="google-site-verification" content="G0eBV4feI13haxUMUDZ_ZW84O-IH-lTJ00kT0BhQ_bw" />

    <link rel="stylesheet" href="style-portfolio.css">
    <link rel="icon" type="image/png" href="./img-portfolio/lettre-r (7).png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    
</head>

<body class="light">
<header>
        <div class="logo-reyan">
            <a href="./index.php">
                <img src="./img-portfolio/lettre-r (7).png" alt="Logo">
            </a>
        </div>
        <div class="menu">
            <div class="acp"><a href="./index.php">Accueil</a></div>
            <div class="acp"><a href="./comp-portfolio.php">Compétences</a></div>
            <div class="acp"><a href="./projet-portfolio.php">Projets</a></div>
            <div class="contact">
                <a href="./contact-portfolio.php">
                    Contact <img src="./img-portfolio/fleche-droite (6).png">
                </a>
            </div>
            <div class="btn-toggle">
            </div>
        </div>
        <div class="menuham" onclick="toggleMenu()">
            <img src="./img-portfolio/menu (1).png" alt="Menu">
        </div>
    </header>
    <nav id="menu" class="menu-hidden">
        <ul>
            <li><a href="./index.php" class="active">Accueil</a></li>
            <li><a href="./comp-portfolio.php">Compétences</a></li>
            <li><a href="./projet-portfolio.php">Projets</a></li>
            <li><a href="./contact-portfolio.php">Contact</a></li>
            <li><div class="btn-toggle"></div></li>
        </ul>
    </nav>