<?php

namespace Shortener;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
    // Credentials
    private string $host;
    private string $dbname;
    private string $user;
    private string $password;
    private int $port;

    // PDO Objects
    private PDO $pdo;
    private PDOStatement $stmt;

    private static ?Database $instance = null;

    public function __construct(string $host, int $port, string $dbname, string $user, string $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;
        $this->connect();
    }

    public static function getInstance(string $host, int $port, string $dbname, string $user, string $password): Database
    {
        if (self::$instance === null) {
            self::$instance = new self($host, $port, $dbname, $user, $password);
        }
        return self::$instance;
    }

    private function connect(): void
    {
        $dsn = "pgsql:host=$this->host;
                port=$this->port;
                dbname=$this->dbname;
                user=$this->user;
                password=$this->password";

        try {
            $this->pdo = new PDO($dsn);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            die();
        }

    }

    public function query(string $query, array $params = []): false|array
    {
        $this->stmt = $this->pdo->prepare($query);
        $this->stmt->execute($params);
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execute(string $query, array $params = []): bool
    {
        $this->stmt = $this->pdo->prepare($query);
        return $this->stmt->execute($params);
    }

    public function getResult(): false|array
    {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function beginTransaction(): void
    {
        $this->pdo->beginTransaction();
    }

    public function commit(): void
    {
        $this->pdo->commit();
    }

    public function rollBack(): void
    {
        $this->pdo->rollBack();
    }

    public function getLastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }

}