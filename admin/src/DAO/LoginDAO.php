<?php 

namespace src\DAO;

use src\Model\Login;
use PDO;

class LoginDAO
{
    private PDO $connexion;

    public function __construct(PDO $connexion)
    {
        $this->connexion = $connexion;
    }

    public function checkLogin(string $username, string $password): ?Login
    {
        $stmt = $this->connexion->prepare(
            "SELECT id, username, password FROM admin WHERE username = :username"
        );

        $stmt->execute([
            'username' => $username
        ]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        if (!password_verify($password, $data['password'])) {
            return null;
        }

        return new Login(
            $data['id'],
            $data['username'],
            '' // on ne stocke PAS le mot de passe après login
        );
    }
}
