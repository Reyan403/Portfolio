<?php
include 'includes/erreurs.php';
include 'includes/header.php';
?>

    <section class="bloc-contact">
        <h2 class="slide-in-top">Contactez-moi !</h2>
        <?php
            if (isset($_SESSION['success_message'])) {
                echo '<p>' . $_SESSION['success_message'] . '</p>';
                unset($_SESSION['success_message']); 
            }
        ?>
        <div class="bloc-contact-container slide-in-bottom">
            <form method="POST" action="contact-portfolio.php">
                <div class="form-nom-mail">
                    <div class="form-group">
                        <label for="nom">Nom * :</label>
                        <input type="text" name="nom" id="nom" placeholder="Entrez votre nom" value="<?php echo $nom; ?>">
                        <span class="error-message"> <?php echo $errors['nom'] ?? ''; ?> </span>
                    </div>

                    <div class="form-group">
                        <label for="email">Adresse e-mail * :</label>
                        <input type="text" name="email" id="email" placeholder="Entrez votre mail" value="<?php echo $email; ?>">
                        <span class="error-message"> <?php echo $errors['email'] ?? ''; ?> </span>
                    </div>
                </div>

                <label for="objet">Objet * :</label>
                <input type="text" name="objet" id="objet" placeholder="Entrez l'objet du message" value="<?php echo $objet; ?>">
                <span class="error-message"> <?php echo $errors['objet'] ?? ''; ?> </span>

                <label for="message">Message * :</label>
                <textarea name="message" id="message" placeholder="Entrez votre message" rows="5"><?php echo $message; ?></textarea>
                <span class="error-message"> <?php echo $errors['message'] ?? ''; ?> </span>

                <input type="submit" value="Valider" name="ok">
            </form>
        </div>
    </section>

<?php
include 'includes/footer.php';
?>

<script src="script.js"></script>

</body>
</html>