<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\UserModel;
use PDO;

class UserRepository
{
    private ?PDO $db=null;

    public function __construct()
    {
        $this->db = Database::getConnection();    
    }

    public function findByEmail(string $email): ?UserModel {
        $selectUser = $this->db->prepare("SELECT id, full_name, password_hash FROM users WHERE email = ?");
        $selectUser->execute([$email]);
        $selectUser->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE , UserModel::class, [null, null, null, null, null]);
        $user= $selectUser->fetch();

        return $user ?: null;
    }

    public function create(UserModel $user):int
    {
        $insertingUser = $this->db->prepare("INSERT INTO users (full_name, email, password_hash)
                                            VALUES (?,?,?)");
        $insertingUser->execute([$user->getFname(), $user->getEmail(), $user->getPassword()]);
        return (int) $this->db->lastInsertId();
    }

}

?>