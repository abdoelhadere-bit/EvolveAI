<?php

namespace app\Core;

use PDO;
use PDOException;
use RuntimeException;


class Connection
{
  private static ?PDO $instance = null;

  private function __construct() {}
  private function __clone() {}
  public function __wakeup() 
  {
    throw new \Exception("Cannot unserialize a singleton.");
  }

  public static function getConnection(): PDO
    {
        if (self::$instance === null) {

            $config = require __DIR__ . '/../../config/database.php';

            $dsn ="pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
             
            try{
                self::$instance = new PDO(
                $dsn,
                $config['username'],
                $config['password'],
                $options
            );
            } catch(PDOException $e)
              {
                  throw new RuntimeException
                  (
                     "Database connection failed",
                     0,
                     $e
                  );
              }
            
        }

        return self::$instance;
    }
}


?>