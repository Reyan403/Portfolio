<?php

namespace DAO;

use Model\StaffMember; 

class StaffMemberDAO
{
    private \PDO $connexion;

    public function __construct(\PDO $connexion) {
        $this->connexion = $connexion;
    }

    public function insert(StaffMember $staff): void {
        $stmt = $this->connexion->prepare("
            INSERT INTO staff_member (firstname, lastname, role, picture)
            VALUES (:firstname, :lastname, :role, :picture)
        ");
        $stmt->execute([
            ":firstname" => $staff->getFirstname(),
            ":lastname" => $staff->getLastname(),
            ":role" => $staff->getRole(),
            ":picture" => $staff->getPicture()
        ]);
    }

    public function getAll(): array {
        $stmt = $this->connexion->query("SELECT * FROM staff_member");

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
