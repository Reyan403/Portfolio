<?php

namespace DAO;

use Model\Player;
use Model\Team;
use Model\PlayerHasTeam;
use Enumeration\PlayerRole;
use PDO;

class PlayerHasTeamDAO 
{
    private \PDO $connexion;

    public function __construct(\PDO $connexion) {
        $this->connexion = $connexion;
    }

    public function insert(PlayerHasTeam $playerHasTeam): void {
        $stmt = $this->connexion->prepare("
            INSERT INTO player_has_team (player_id, team_id, role)
            VALUES (:player_id, :team_id, :role)
        ");
        $stmt->execute([
            ":player_id" => $playerHasTeam->getPlayer()->getId(),
            ":team_id" => $playerHasTeam->getTeam()->getId(),
            ":role" => $playerHasTeam->getRole()->value
        ]);
    }

    public function updateTeamAndRole(PlayerHasTeam $playerHasTeam, int $originalTeamId): void {
    $stmt = $this->connexion->prepare("
        UPDATE player_has_team
        SET team_id = :new_team_id, role = :role
        WHERE player_id = :player_id AND team_id = :original_team_id
    ");
    $stmt->execute([
        ':new_team_id' => $playerHasTeam->getTeam()->getId(),
        ':role' => $playerHasTeam->getRole()->value,
        ':player_id' => $playerHasTeam->getPlayer()->getId(),
        ':original_team_id' => $originalTeamId
    ]);
}

   public function remove(PlayerHasTeam $playerHasTeam): void {
        $stmt = $this->connexion->prepare("
            DELETE FROM player_has_team 
            WHERE player_id = :player_id AND team_id = :team_id
        ");
        $stmt->execute([
            ':player_id' => $playerHasTeam->getPlayer()->getId(),
            ':team_id'   => $playerHasTeam->getTeam()->getId()
        ]);
    }

    public function getAll(): array
    {
        $sql = "SELECT 
                    pht.player_id, 
                    pht.team_id, 
                    pht.role,
                    p.firstname AS player_firstname, 
                    p.lastname AS player_lastname,
                    t.name AS team_name
                FROM player_has_team pht
                JOIN player p ON pht.player_id = p.id
                JOIN team t ON pht.team_id = t.id";
        $stmt = $this->connexion->query($sql); 
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findById(int $playerId, int $teamId): ?array {
        $sql = "
            SELECT 
                pht.player_id, 
                pht.team_id, 
                pht.role,
                p.firstname AS firstname, 
                p.lastname AS lastname,
                t.name AS team_name
            FROM player_has_team pht
            JOIN player p ON pht.player_id = p.id
            JOIN team t ON pht.team_id = t.id
            WHERE pht.player_id = :player_id AND pht.team_id = :team_id
        ";

        $stmt = $this->connexion->prepare($sql);
        $stmt->execute([
            ':player_id' => $playerId,
            ':team_id' => $teamId
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retourne simplement un tableau associatif
        return [
            'player_id' => (int)$row['player_id'],
            'player_firstname' => $row['firstname'],
            'player_lastname' => $row['lastname'],
            'team_id' => (int)$row['team_id'],
            'team_name' => $row['team_name'],
            'role' => $row['role'] // garde la liste des rôles telle quelle
        ];
    }
}
