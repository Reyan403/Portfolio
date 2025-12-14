<?php

namespace src\Model;

class Projet
{
    private $id;
    private $titre;
    private $date;
    private $description;
    private $technologies;
    private $lien;
    private $image;
    private $categorie;

    // Constructeur avec valeurs par défaut
    public function __construct(?int $id = null, ?string $titre = null, ?string $date = null, ?string $description = null, ?string $technologies = null, ?string $lien = null, ?string $image = null, ?string $categorie = null)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->date = $date;
        $this->description = $description;
        $this->technologies = $technologies;
        $this->lien = $lien;
        $this->image = $image;
        $this->categorie = $categorie;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTechnologies(): string
    {
        return $this->technologies;
    }

    public function getLien(): string
    {
        return $this->lien;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setTechnologies(string $technologies): void
    {
        $this->technologies = $technologies;
    }

    public function setLien(string $lien): void
    {
        $this->lien = $lien;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function setCategorie(?string $categorie): void
    {
        $this->categorie = $categorie;
    }
}
