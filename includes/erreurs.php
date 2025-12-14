<?php

session_start(); 

$nom = $email = $objet = $message = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validation du nom (au moins 2 lettres)
    if (empty($_POST["nom"])) {
        $errors['nom'] = "Veuillez saisir le nom.";
    } elseif (strlen($_POST["nom"]) < 2) {
        $errors['nom'] = "Le nom doit contenir au moins 2 lettres.";
    } elseif (!ctype_alpha($_POST["nom"])) {
        $errors['nom'] = "Le nom ne doit contenir que des lettres.";
    } else {
        $nom = htmlspecialchars($_POST["nom"]);
    }

    if (empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Format d'email invalide.";
    } else {
        $email = htmlspecialchars($_POST["email"]);
    }

    if (empty($_POST["objet"])) {
        $errors['objet'] = "Veuillez saisir l'objet.";
    } else {
        $objet = htmlspecialchars($_POST["objet"]);
    }

    if (empty($_POST["message"])) {
        $errors['message'] = "Veuillez saisir un message.";
    } else {
        $message = htmlspecialchars($_POST["message"]);
    }

    if (empty($errors)) {

        $to = "ghazzaoui.reyan@gmail.com";
        $subject = "Nouveau message : " . $objet;

        $content = "Nom : $nom\n";
        $content .= "Email : $email\n\n";
        $content .= "Message :\n$message\n";

        $headers = "From: contact@ton-domaine.com\r\n"; 
        $headers .= "Reply-To: $email\r\n";

        if (mail($to, $subject, $content, $headers)) {

            $_SESSION['success_message'] = "Votre message a bien été envoyé.";
            header("Location: contact-portfolio.php");
            exit();

        } else {

            $errors['mail'] = "Erreur lors de l’envoi du message.";

        }
    }
}