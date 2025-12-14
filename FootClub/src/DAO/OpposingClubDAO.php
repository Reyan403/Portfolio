<?php

namespace DAO;

use Model\OpposingClub;

class OpposingClubDAO
{
    private \PDO $connexion;

    public function __construct(\PDO $connexion)
    {
        $this->connexion = $connexion;
    }

    public function insert(OpposingClub $club): void
    {
        $stmt = $this->connexion->prepare("
            INSERT INTO opposing_club (address, city)
            VALUES (:address, :city)
        ");
        $stmt->execute([
            ':address' => $club->getAddress(),
            ':city'    => $club->getCity()
        ]);
    }

    public function update(OpposingClub $club): void
    {
        $stmt = $this->connexion->prepare("
            UPDATE opposing_club
            SET address = :address,
                city = :city
            WHERE id = :id
        ");
        $stmt->execute([
            ':address' => $club->getAddress(),
            ':city'    => $club->getCity(),
            ':id'      => $club->getId()
        ]);
    }

    public function remove(OpposingClub $club): void
    {
        $stmt = $this->connexion->prepare("DELETE FROM opposing_club WHERE id = :id");
        $stmt->execute([':id' => $club->getId()]);
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM opposing_club";
        $stmt = $this->connexion->prepare($sql);
        $stmt->execute();
        $clubDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $clubs = [];

        foreach ($clubDatas as $clubData) {
            $clubs[] = new OpposingClub(
                $clubData['id'],
                $clubData['address'],
                $clubData['city']
            );
        }

        return $clubs;
    }

    public function findById(int $id): ?OpposingClub
    {
        $stmt = $this->connexion->prepare("SELECT * FROM opposing_club WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $clubDatas = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($clubDatas) {
            return new OpposingClub(
                id: $clubDatas['id'],
                address: $clubDatas['address'],
                city: $clubDatas['city']
            );

            return null;
        }
    }
}
