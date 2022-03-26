<?php

declare(strict_types = 1);

namespace App\Database;

use PDO;

class Database {
    private PDO $connection;

    public function __construct() {
        $host = "mysql";
        $port = "3306";
        $dbname = "scandiweb";
        $charset = "utf8mb4";

        $user = "root";
        $password = "scandiweb";
        
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

       try {
            $this->connection = new PDO($dsn, $user, $password, [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
       } catch (\PDOException $e) {
           throw new \PDOException($e->getMessage(), (int) $e->getCode());
       }
    }

    public function getConnection(): PDO {
        return $this->connection;
    }
}