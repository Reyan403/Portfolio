<?php

namespace Model;

Class Team 
{
    private ?int $id;
    private string $name;

    private array $games = [];

    public function __construct(?int $id, string $name) 
    {
        $this->id = $id;
        $this->name = $name;
    }

    // GETTERS
    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getName(): string 
    {
        return $this->name;
    }

    public function getGame(): array 
    {
        return $this->games;
    }

    // SETTERS
    public function setId(int $id) 
    {
        $this->id = $id;
    }

    public function setName(string $name) 
    {
        $this->name = $name;
    }

    public function setGame(array $game) 
    {
        $this->games = $games;
    }

    // METHODES
    public function addMatch(Game $game) 
    {
        $this->games[] = $game;
    }
}