<?php

namespace src\DAO;

use src\Model\Projet;
use PDO;

class ProjetDAO
{
    private PDO $connexion;

    public function __construct(PDO $connexion)
    {
        $this->connexion = $connexion;
    }

    public function insert(Projet $projet): void
    {
        $stmt = $this->connexion->prepare("
            INSERT INTO projets (titre, date, description, technologies, lien, images, categorie)
            VALUES (:titre, :date, :description, :technologies, :lien, :images, :categorie)
        ");

        $stmt->execute([
            ':titre'        => $projet->getTitre(),
            ':date'         => $projet->getDate(),
            ':description'  => $projet->getDescription(),
            ':technologies' => $projet->getTechnologies(),
            ':lien'         => $projet->getLien(),
            ':images'       => $projet->getImage(),
            ':categorie'    => $projet->getCategorie()
        ]);
    }

    public function update(Projet $projet): void
    {
        $stmt = $this->connexion->prepare("
            UPDATE projets
            SET titre = :titre,
                date = :date,
                description = :description,
                technologies = :technologies,
                lien = :lien,
                images = :images,
                categorie = :categorie
            WHERE id = :id
        ");

        $stmt->execute([
            ':titre'        => $projet->getTitre(),
            ':date'         => $projet->getDate(),
            ':description'  => $projet->getDescription(),
            ':technologies' => $projet->getTechnologies(),
            ':lien'         => $projet->getLien(),
            ':images'       => $projet->getImage(),
            ':categorie'    => $projet->getCategorie(),
            ':id'           => $projet->getId()
        ]);
    }

    public function remove(Projet $projet): void
    {
        $stmt = $this->connexion->prepare("
            DELETE FROM projets WHERE id = :id
        ");

        $stmt->execute([
            ':id' => $projet->getId()
        ]);
    }

    public function getAll(): array
    {
        $stmt = $this->connexion->prepare("SELECT * FROM projets");
        $stmt->execute();
        $projetsDatas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $projets = [];

        foreach ($projetsDatas as $projetData) {
            $projets[] = new Projet(
                $projetData['id'],
                $projetData['titre'],
                $projetData['date'],
                $projetData['description'],
                $projetData['technologies'],
                $projetData['lien'],
                $projetData['images'],
                $projetData['categorie'] ?? null
            );
        }

        return $projets;
    }

    public function findById(int $id): ?Projet
    {
        $stmt = $this->connexion->prepare("SELECT * FROM projets WHERE id = :id");

        $stmt->execute([
            ':id' => $id
        ]);

        $projetData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($projetData) {
            return new Projet(
                $projetData['id'],
                $projetData['titre'],
                $projetData['date'],
                $projetData['description'],
                $projetData['technologies'],
                $projetData['lien'],
                $projetData['images'],
                $projetData['categorie'] ?? null
            );
        }

        return null;
    }
}
