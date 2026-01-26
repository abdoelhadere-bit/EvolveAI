<?php
namespace App\Models;

use App\Core\Database;
use PDO;


final class UserStateModel
{
    public function __construct(private \PDO $pdo) {}

    public function ensure(int $userId): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_state(user_id) VALUES(:uid) ON CONFLICT (user_id) DO NOTHING");
        $stmt->execute([':uid' => $userId]);
    }

    public function setActiveOpportunity(int $userId, int $oppId): void
    {
        $this->ensure($userId);
        $stmt = $this->pdo->prepare("
            UPDATE user_state
            SET active_opportunity_id = :opp, updated_at = NOW()
            WHERE user_id = :uid
        ");
        $stmt->execute([':uid' => $userId, ':opp' => $oppId]);
    }

    // retourne le nouveau day_number
    public function incrementDay(int $userId): int
    {
        $this->ensure($userId);

        $stmt = $this->pdo->prepare("
            UPDATE user_state
            SET current_day_number = current_day_number + 1, updated_at = NOW()
            WHERE user_id = :uid
            RETURNING current_day_number
        ");
        $stmt->execute([':uid' => $userId]);

        return (int)$stmt->fetchColumn();
    }

    public function getActiveOpportunityId(int $userId): ?int
    {
        $this->ensure($userId);
        $stmt = $this->pdo->prepare("SELECT active_opportunity_id FROM user_state WHERE user_id = :uid");
        $stmt->execute([':uid' => $userId]);
        $val = $stmt->fetchColumn();
        return $val === null ? null : (int)$val;
    }
}
