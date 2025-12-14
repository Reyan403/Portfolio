<?php

namespace DAO;

use Model\Team;

class TeamDAO
{
    private \PDO $connexion;

    public function __construct(\PDO $connexion)
    {
        $this->connexion = $connexion;
    }

    public function insert(Team $team): void
    {
        $stmt = $this->connexion->prepare("
            INSERT INTO team (name)
            VALUES (:name)
        ");
        $stmt->execute([
            ':name' => $team->getName(),
        ]);
    }
 
    public function update(Team $team): void
    {
        $stmt = $this->connexion->prepare("
            UPDATE team
            SET name = :name
            WHERE id = :id
        ");
        $stmt->execute([
            ':name' => $team->getName(),
            ':id'   => $team->getId(),
        ]);
    }

    public function remove(Team $team): void
    {
        $stmt = $this->connexion->prepare("
            DELETE FROM team WHERE id = :id
        ");
        $stmt->execute([
            ':id' => $team->getId(),
        ]);
    }

    public function findById(int $id): ?Team
    {
        $stmt = $this->connexion->prepare("
            SELECT * FROM team WHERE id = :id
        ");
        $stmt->execute([':id' => $id]);
        $teamDatas = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($teamDatas) {
            return new Team(
                $teamDatas['id'],
                $teamDatas['name']
            );
        }

        return null;
    }

    public function getAll(): array
    {
        $stmt = $this->connexion->prepare("SELECT * FROM team");
        $stmt->execute();
        $teamDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $teams = [];

        foreach ($teamDatas as $teamData) {
            $teams[] = new Team(
                $teamData['id'],
                $teamData['name']
            );
        }

        return $teams;
    }
}
