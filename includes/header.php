<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-portfolio.css">
    <link rel="icon" type="image/png" href="./img-portfolio/lettre-r (7).png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    
    <title>Portfolio</title>
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
            <div class="links">
                <div class="git-hub">
                    <a href="https://github.com/Reyan403" target="_blank" rel="noopener noreferrer">
                        <img src="./img-portfolio/github (1).png" alt="">
                    </a>
                </div>
                <div class="download">
                    <a href="./img-portfolio/CV_Reyan_GHAZZAOUI.pdf" download="CV-Reyan-Ghazzaoui.pdf">
                        <img src="./img-portfolio/cv (1).png" alt="Télécharger mon CV">
                    </a>
                </div>
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
            <div class="links">
                <div class="git-hub">
                    <a href="https://github.com/Reyan403">
                        <img src="./img-portfolio/github (1).png" alt="">
                    </a>
                </div>
                <div class="download">
                    <a href="./img-portfolio/CV_Reyan_GHAZZAOUI.pdf" download="CV-Reyan-Ghazzaoui.pdf">
                        <img src="./img-portfolio/cv (1).png" alt="Télécharger mon CV">
                    </a>
                </div>
            </div>
            <li><div class="btn-toggle"></div></li>
        </ul>
    </nav>