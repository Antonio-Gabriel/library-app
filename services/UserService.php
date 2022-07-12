<?php

namespace services;

use configs\Sql;

class UserService
{
    private Sql $sql;

    public function __construct()
    {
        $this->sql = new Sql();
    }

    public function save(string $name, string $email, string $password)
    {
        return $this->sql->query(
            "INSERT INTO user_account (name, email, password) 
             VALUES (:name, :email, :password)",
            [
                ":name" => $name,
                ":email" => $email,
                ":password" => $password
            ]
        );
    }

    public function findByEmail(string $email)
    {
        return $this->sql->select(
            "SELECT * FROM user_account WHERE email = :email",
            [
                ":email" => $email
            ]
        );
    }
}
