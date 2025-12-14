<?php
include 'includes/header.php';
?>

<body class="light">
    <section class="bloc1-accueil">
        <div class="container-bloc1-accueil">
            <div class="bloc-title">
                <h1 class="slide-in-left">
                    Mon Portfolio
                </h1>
                <p class="slide-in-right">
                    Réalisé par <strong>Reyan Ghazzaoui</strong>
                </p>
            </div>
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
            <div class="linkedin">
                <a href="https://www.linkedin.com/in/reyan-ghazzaoui-7a538a249/" target="_blank" rel="noopener noreferrer">
                    <img src="./img-portfolio/linkedin.png" alt="">
                </a>
            </div>
        </div>
    </section>

    <section id="bloc2-accueil">
        <div class="apropos-accueil-container">
            <div class="text-bloc">
                <h2 class="slide-in-top">
                    Profil
                </h2>
                <p class="slide-in-left">
                    Je m'appelle <strong>Reyan Ghazzaoui</strong>, j'ai 18 ans, je suis un élève de BTS SIO au lycée Saint Vincent à Senlis. Durant ma première année de BTS, <strong>j'ai acquis plusieurs compétences grâce aux projets que j'ai pu réalisé</strong>. Je suis passionné par le développement web et je souhaite poursuivre ma licence dans ce même lycée.
                </p>
                <div class="two-buttons slide-in-bottom">
                    <a href="./comp-portfolio.php" class="button-comp">
                        Voir les compétences <img src="./img-portfolio/fleche-droite (6).png">
                    </a>
                    <a href="./projet-portfolio.php" class="button-projects">
                        Voir les projets <img src="./img-portfolio/fleche-droite (7).png">
                    </a>
                </div>
            </div>
            <div class="img-bloc slide-in-right">
                <img src="./img-portfolio/2N9A0162 (1).jpg">
            </div>
        </div>
    </section>

    <section class="bloc3-accueil">
        <div class="container-title">
            <h2 class="slide-in-top">Mes projets</h2>
        </div>
        <div class="container-carousel slide-in-right">
            <div class="nav-arrows">
                <img class="slide-in-left" src="./img-portfolio/chevron-gauche.png" class="button-arrow-left" id="g">
            </div>
            <div id="carousel">
                <div id="container"></div>
                <div id="container"></div>
            </div>
            <div class="nav-arrows">
                <img src="./img-portfolio/chevron-gauche.png" class="button-arrow-left" id="d">
            </div>
        </div>
        <div class="learn-more button-accueil slide-in-bottom">
            <a href="./projet-portfolio.php">
                En savoir plus <img src="./img-portfolio/fleche-droite (6).png" alt="">
            </a>
        </div>
    </section>

    <section class="bloc4-accueil">
        <div class="container-comp">
            <div class="title-comp">
                <h2 class="slide-in-top">Mes compétences</h2>
            </div>
            <div class="img-comp">
                <div class="front-end slide-in-left">
                    <img src="./img-portfolio/html.png" alt="">
                    <img src="./img-portfolio/css.png" alt="">
                    <img src="./img-portfolio/js.png" alt="">
                </div>
                <div class="back-end slide-in-right">
                    <img src="./img-portfolio/php.png" alt="">
                    <img class="sql" src="./img-portfolio/mysql (1).png" alt="">
                    <img src="./img-portfolio/c-sharp.png" alt="">
                    <img src="./img-portfolio/symfony.svg" alt="">
                </div>
            </div>
            <div class="learn-more button-accueil slide-in-bottom">
                <a href="./comp-portfolio.php">
                    En savoir plus <img src="./img-portfolio/fleche-droite (6).png" alt="">
                </a>
            </div>
        </div>
    </section>

<?php
include 'includes/footer.php';
?>

<script src="script.js"></script>
</body>
</html>