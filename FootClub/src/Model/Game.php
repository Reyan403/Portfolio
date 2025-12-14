<?php

namespace Model;

Class Game 
{
    private ?int $id;
    private int $teamScore;
    private int $opponentScore;
    private \DateTime $date;
    private string $city;
    private Team $team;
    private Opposingclub $opposingClub;

    public function __construct(?int $id, \DateTime $date, string $city,int $teamScore, int $opponentScore, Team $team, OpposingClub $opposingClub)
    {
        $this->id = $id;
        $this->teamScore = $teamScore;
        $this->team = $team;
        $this->opponentScore = $opponentScore;
        $this->date = $date;
        $this->city = $city;
        $this->opposingClub = $opposingClub;
    }

    // GETTERS
    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getTeamScore(): int 
    {
        return $this->teamScore;
    }

    public function getTeam(): Team 
    {
        return $this->team;
    }

    public function getOpponentScore(): int 
    {
        return $this->opponentScore;
    }

    public function getDate(): \DateTime 
    {
        return $this->date;
    }

    public function getCity(): string 
    {
        return $this->city;
    }

    public function getOpposingClub(): Opposingclub 
    {
        return $this->opposingClub;
    }

    // SETTERS
    public function setId(int $id) 
    {
        $this->id = $id;
    }

    public function setTeamScore(int $teamScore) 
    {
        $this->teamScore = $teamScore;
    }

    public function setOpponentScore(int $opponentScore) 
    {
        $this->opponentScore = $opponentScore;
    }

    public function setDate(\DateTime $date) 
    {
        $this->date = $date;
    }

    public function setCity(string $city) 
    {
        $this->city = $city;
    }

    public function setOpposingClubId(Opposingclub $opposingClub) 
    {
        $this->opposingClub = $opposingClub;
    }

    public function setTeam(Team $team): void
    {
        $this->team = $team;
    }

    public function setOpposingClub(OpposingClub $opposingClub): void
    {
        $this->opposingClub = $opposingClub;
    }

}