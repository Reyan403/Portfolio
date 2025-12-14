<?php

namespace src\Service;

class Validation
{
    public static function validateImageUpload(array $file, string $targetDir): string
    {
        if (!isset($file) || $file["error"] !== 0) {
            throw new \Exception("Veuillez sélectionner une image valide.");
        }

        $fileName = basename($file["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        
        $allowTypes = ['jpg', 'png', 'jpeg', 'gif', 'webp'];
        if (!in_array(strtolower($fileType), $allowTypes)) {
            throw new \Exception("Désolé, seuls les fichiers JPG, JPEG, PNG, WEBP & GIF sont autorisés.");
        }

        if (!move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            throw new \Exception("Désolé, une erreur est survenue lors de l'upload de votre fichier.");
        }

        return $fileName;
    }

    public static function validateProjetData(string $titre, string $description, string $categorie): void
    {
        if (empty(trim($titre)) || empty(trim($description)) || empty(trim($categorie))) {
            throw new \Exception("Veuillez remplir tous les champs obligatoires (Titre, Description, Catégorie).");
        }
    }
}
