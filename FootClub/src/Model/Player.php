<?php

namespace Model;

Class Player 
{
    private ?int $id;
    private string $firstname;
    private string $lastname;
    private \DateTime $birthdate;
    private ?string $picture;
    
    // Un joueur peut appartenir à une ou plusieurs équipes
    private array $teams = []; 

    public function __construct(?int $id, string $firstname, string $lastname, \DateTime $birthdate, ?string $picture) 
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->birthdate = $birthdate;
        $this->picture = $picture;
    }

    // GETTERS
    public function getId(): ?int 
    {
        return $this->id;
    }
    
    public function getFirstname(): string 
    {
        return $this->firstname;
    }

    public function getLastname(): string 
    {
        return $this->lastname;
    }

    public function getBirthdate(): \DateTime 
    {
        return $this->birthdate;
    }

    public function getPicture(): ?string 
    {
        return $this->picture;
    }

    public function getTeams(): array 
    {
        return $this->teams;
    }

    // SETTERS
    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function setFirstname(string $firstname) : void
    {
        $this->firstname = $firstname;
    }

    public function setLastname(string $lastname) : void
    {
        $this->lastname = $lastname;
    }

    public function setBirthdate(\DateTime $birthdate) : void
    {
        $this->birthdate = $birthdate;
    }

    public function setPicture(string $picture) : void
    {
        $this->picture = $picture;
    }

    public function setTeams(array $teams): void 
    {
        $this->teams = $teams;
    }

    // METHODES
    public function addTeam(PlayerHasTeam $team) 
    {
        $this->teams[] = $team;
    }
}