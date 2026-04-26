<?php

namespace Ocore;

use PDO;
use PDOStatement;

class Database
{
    protected PDO $connection;
    protected PDOStatement $statement;

    public function __construct()
    {
        $host = DB['db_host'];
        $db = DB['db_name'];
        $port = DB['db_port'];
        $charset = DB['charset'];

        $user = DB['username'];
        $pass = DB['user_password'];
        $options = DB['options'];

        $dsn = "mysql:host=$host;dbname=$db;port=$port;charset=$charset";

        try {
            $this->connection = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            error_log("[". date('Y-m-d H:i:s') ."] DB ERROR: {$e->getMessage()}" . PHP_EOL, 3, ERROR_LOG_PATH);
            if (DEBUG) {
                abort(500, null, "Connection failed: " . $e->getMessage());
            } else {
                abort(500);
            }
        }

        return $this;
    }

    public function query(string $query, array $params = []): static
    {
        try {
            $this->statement = $this->connection->prepare($query);
            $this->statement->execute($params);
        } catch (\PDOException $e) {
            error_log("[". date('Y-m-d H:i:s') ."] DB ERROR: {$e->getMessage()}" . PHP_EOL, 3, ERROR_LOG_PATH);
            if (DEBUG) {
                abort(500, null, "Query failed: " . $e->getMessage());
            } else {
                abort(500);
            }
        }
        return $this;
    }

    public function asArray(): array
    {
        return $this->statement->fetchAll();
    }

    public function findAll(string $tableName): array|false
    {
        return $this->query("SELECT * FROM $tableName")->asArray();
    }

    public function findOne(string $tableName, int $id): mixed
    {
        $this->query("SELECT * FROM $tableName WHERE id = :id LIMIT 1", ['id' => $id]);
        return $this->statement->fetch();
    }

    public function findOrFail(string $tableName, int $id, string|null $failTitle = null, string|null $failText = null): mixed
    {
        $result = $this->findOne($tableName, $id);
        if (!$result) {
            abort(404, $failTitle, $failText);
        }
        return $result;
    }

    public function getInsertId(): false|string
    {
        return $this->connection->lastInsertId();
    }

    public function affectedRows(): int
    {
        return $this->statement->rowCount();
    }
}