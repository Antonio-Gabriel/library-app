<?php

namespace configs;

use PDO;

class Sql
{
    protected PDO $conn;

    private $params = [
        "db" => [
            "hostname" => "localhost",
            "dbname" => "library",
            "user" => "root",
            "password" => ""
        ]
    ];

    public function __construct()
    {
        $connParams = (object)$this->params["db"];

        $this->conn = new PDO(
            "mysql:dbname={$connParams->dbname};host={$connParams->hostname}",
            $connParams->user,
            $connParams->password,
            [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
        );
    }

    private function setParams($statement, $params = [])
    {
        foreach ($params as $key => $value) {
            // Dynamic bin params

            $this->bindParams($statement, $key, $value);
        }
    }

    private function bindParams($statement, $key, $value)
    {
        $statement->bindParam($key, $value);
    }

    public function query(string $query, $params = [])
    {
        $stmt = $this->conn->prepare($query);
        $this->setParams($stmt, $params);

        return $stmt->execute();
    }

    public function select(string $query, $params = [])
    {
        $stmt = $this->conn->prepare($query);
        $this->setParams($stmt, $params);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
