<?php

namespace DAO;

use Model\Player;

class PlayerDAO
{
    private \PDO $connexion;

    public function __construct(\PDO $connexion)
    {
        $this->connexion = $connexion;
    }

    public function insert(Player $player): void
    {
        $stmt = $this->connexion->prepare("
            INSERT INTO player (firstname, lastname, birthdate, picture)
            VALUES (:firstname, :lastname, :birthdate, :picture)
        ");
        $stmt->execute([
            ':firstname' => $player->getFirstname(),
            ':lastname' => $player->getLastname(),
            ':birthdate' => $player->getBirthdate()->format('Y-m-d'),
            ':picture' => $player->getpicture()
        ]);
    }

    public function update(Player $player): void
    {
        $stmt = $this->connexion->prepare(
            "UPDATE player SET firstname = :firstname, lastname = :lastname, birthdate = :birthdate WHERE id = :id"
        );
        $stmt->execute([
            ':firstname' => $player->getFirstname(),
            ':lastname'  => $player->getLastname(),
            ':birthdate' => $player->getBirthdate()->format('Y-m-d'),
            ':id'        => $player->getId()
        ]);
    }

    public function remove(Player $player): void
    {
        $stmt = $this->connexion->prepare(
            "DELETE FROM player WHERE id = :id"
        );

        $stmt->execute([
            ':id' => $player->getId()
        ]);
    }


    public function getAll(): array
    {
        $stmt = $this->connexion->prepare("SELECT * FROM player");
        $stmt->execute();
        $playerDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $players = [];

        foreach ($playerDatas as $playerData) {
            $players[] = new Player(
                $playerData['id'],
                $playerData['firstname'],
                $playerData['lastname'],
                new \DateTime($playerData['birthdate']),
                $playerData['picture']
            );
        }

        return $players;
    }

    public function findById(int $id): ?Player
    {
        $stmt = $this->connexion->prepare("SELECT * FROM player WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $playerData = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($playerData) {
            return new Player(
                $playerData['id'],
                $playerData['firstname'],
                $playerData['lastname'],
                new \DateTime($playerData['birthdate']),
                $playerData['picture']
            );
        }

        return null; 
    }
}
