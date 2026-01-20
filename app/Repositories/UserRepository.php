<?php

namespace app\Repositories;

use app\Core\Connection;
use app\Model\User;
use PDO;

class UserRepository
{
    private ?PDO $db=null;

    public function __construct()
    {
        $this->db = Connection::getConnection();    
    }

    public function findByEmail(string $email): ?User {
        $selectUser = $this->db->prepare("SELECT id, full_name, password_hash FROM users WHERE email = ?");
        $selectUser->execute([$email]);
        $selectUser->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE , User::class, [null, null, null, null, null]);
        $user= $selectUser->fetch();

        return $user ?: null;
    }

    public function create(User $user):void
    {
        $insertingUser = $this->db->prepare("INSERT INTO users (full_name, email, password)
                                            VALUES (?,?,?)");
        $insertingUser->execute([$user->getFname(), $user->getEmail(), $user->getPassword()]);
    }

}

?>