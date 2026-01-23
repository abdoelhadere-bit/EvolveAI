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
        $selectUser = $this->db->prepare("SELECT id, full_name, password_hash, email FROM users WHERE email = ?");
        $selectUser->execute([$email]);
        $selectUser->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE , UserModel::class, [null, null, null, null, null]);
        $user= $selectUser->fetch();

        return $user ?: null;
    }

    public function create(UserModel $user):void
    {
        $insertingUser = $this->db->prepare("INSERT INTO users (full_name, email, password_hash)
                                            VALUES (?,?,?)");
        $insertingUser->execute([$user->getFname(), $user->getEmail(), $user->getPassword()]);
    }

    public function updatePassword(int $userId, string $newHashedPassword): bool
    {
        
        $sql = "UPDATE users SET password_hash = :password WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':password', $newHashedPassword);
        $stmt->bindValue(':id', $userId);

        if ($stmt->execute()) {
            return $stmt->rowCount() > 0;
        }

        return false;
    }
}

?>