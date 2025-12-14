<?php 

namespace Model;

use Model\Player;
use Model\Team;
use Enumeration\PlayerRole;

Class PlayerHasTeam 
{
    private Player $player;
    private Team $team;
    private PlayerRole $role;

    public function __construct(Player $player, Team $team, PlayerRole $role) 
    {
        $this->player = $player;
        $this->team = $team;
        $this->role = $role;
    }

    // GETTERS
    public function getPlayer(): Player 
    {
        return $this->player;
    }

    public function getTeam(): Team 
    {
        return $this->team;
    }

    public function getRole(): PlayerRole 
    {
        return $this->role;
    }

    // SETTERS
    public function setPlayer(Player $player) 
    {
        $this->player = $player;
    }

    public function setTeam(Team $team) 
    {
        $this->team = $team;
    }

    public function setRole(PlayerRole $role) 
    {
        $this->role = $role;
    }
}