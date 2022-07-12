<?php

namespace services;

use configs\Sql;
use entities\Author;
use interfaces\IAuthorRepository;

class AuthorService implements IAuthorRepository
{
    private Sql $sql;

    public function __construct()
    {
        $this->sql = new Sql();
    }

    public function save(Author $author)
    {
        return $this->sql->query(
            "INSERT INTO author (name) VALUES (:name)",
            [
                ":name" => $author->props->name
            ]
        );
    }

    public function update(Author $author)
    {
        return $this->sql->query(
            "UPDATE author SET name = :name WHERE id = :id",
            [
                ":id" => $author->getId(),
                ":name" => $author->props->name
            ]
        );
    }

    public function get()
    {
        return $this->sql->select(
            "SELECT *FROM author"
        );
    }

    public function delete(int $authorId)
    {
        return $this->sql->query(
            "DELETE FROM author WHERE id = :id",
            [
                ":id" => $authorId,
            ]
        );
    }

    public function findByAuthorName(string $name)
    {
        return $this->sql->select(
            "SELECT *FROM author WHERE name = :name",
            [
                ":name" => $name
            ]
        );
    }
}
