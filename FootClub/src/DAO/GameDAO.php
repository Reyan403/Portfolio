<?php

namespace DAO;

use Model\Game; 

class GameDAO 
{
    private \PDO $connexion;

    public function __construct(\PDO $connexion)
    {
        $this->connexion = $connexion;
    }

    public function insert(Game $game): void
    {
        $stmt = $this->connexion->prepare("
            INSERT INTO matches (team_score, opponent_score, date, city, team_id, opposing_club_id)
            VALUES (:team_score, :opponent_score, :date, :city, :team_id, :opposing_club_id)
        ");
        $stmt->execute([
            ":team_score" => $game->getTeamScore(),
            ":opponent_score" => $game->getOpponentScore(),
            ":date" => $game->getDate()->format("Y-m-d H:i:s"),
            ":city" => $game->getCity(),
            ":team_id" => $game->getTeam()->getId(),
            ":opposing_club_id" => $game->getOpposingClub()->getId()
        ]);
    }

    public function update(Game $game): void 
    {
        $stmt = $this->connexion->prepare("
            UPDATE matches
            SET team_score = :team_score,
                opponent_score = :opponent_score,
                date = :date,
                city = :city,
                team_id = :team_id,
                opposing_club_id = :opposing_club_id
            WHERE id = :id
        ");
        $stmt->execute([
            ":team_score" => $game->getTeamScore(),
            ":opponent_score" => $game->getOpponentScore(),
            ":date" => $game->getDate()->format("Y-m-d H:i:s"),
            ":city" => $game->getCity(),
            ":team_id" => $game->getTeam()->getId(),
            ":opposing_club_id" => $game->getOpposingClub()->getId(),
            ":id" => $game->getId()
        ]);
    }

    public function remove(Game $game): void 
    {
        $stmt = $this->connexion->prepare("DELETE FROM matches WHERE id = :id");
        $stmt->execute([":id" => $game->getId()]);
    }

   public function getAll(): array 
   {
        $stmt = $this->connexion->query("
            SELECT m.*, 
                t.id AS team_id, t.name AS team_name,
                o.id AS opposing_id, o.address AS opposing_address, o.city AS opposing_city
            FROM matches m
            JOIN team t ON m.team_id = t.id
            JOIN opposing_club o ON m.opposing_club_id = o.id
        ");

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $games = [];

        foreach ($rows as $row) {
            $team = new \Model\Team($row['team_id'], $row['team_name']);

            // ✅ 3 paramètres : id, address, city
            $opposingClub = new \Model\OpposingClub(
                $row['opposing_id'],
                $row['opposing_address'],
                $row['opposing_city']
            );

            $games[] = new \Model\Game(
                $row['id'],
                new \DateTime($row['date']),
                $row['city'],
                (int)$row['team_score'],
                (int)$row['opponent_score'],
                $team,
                $opposingClub
            );
        }

        return $games;
    }

    public function findById(int $id): ?Game 
    {
    $stmt = $this->connexion->prepare("
        SELECT m.*, 
               t.id AS team_id, t.name AS team_name,
               o.id AS opposing_id, o.address AS opposing_address, o.city AS opposing_city
        FROM matches m
        JOIN team t ON m.team_id = t.id
        JOIN opposing_club o ON m.opposing_club_id = o.id
        WHERE m.id = :id
    ");

    $stmt->execute([":id" => $id]);
    $data = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($data) {

        $team = new \Model\Team(
            $data['team_id'],
            $data['team_name']
        );

        $opposingClub = new \Model\OpposingClub(
            $data['opposing_id'],
            $data['opposing_address'],
            $data['opposing_city']
        );

        return new \Model\Game(
            $data['id'],
            new \DateTime($data['date']),
            $data['city'],
            (int)$data['team_score'],
            (int)$data['opponent_score'],
            $team,
            $opposingClub
        );
    }

    return null;
    }
}
