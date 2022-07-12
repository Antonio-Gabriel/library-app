<?php

namespace services;

use configs\Sql;
use entities\Genre;
use interfaces\IGenreRepository;

class GenreService implements IGenreRepository
{
    private Sql $sql;

    public function __construct()
    {
        $this->sql = new Sql();
    }

    public function save(Genre $genre)
    {
        return $this->sql->query(
            "INSERT INTO genre (designation) VALUES (:designation)",
            [
                ":designation" => $genre->props->designation
            ]
        );
    }

    public function update(Genre $genre)
    {
        return $this->sql->query(
            "UPDATE genre SET designation = :designation WHERE id = :id",
            [
                ":id" => $genre->getId(),
                ":designation" => $genre->props->designation
            ]
        );
    }

    public function get()
    {
        return $this->sql->select(
            "SELECT *FROM genre"
        );
    }

    public function delete(int $genreId)
    {
        return $this->sql->query(
            "DELETE FROM genre WHERE id = :id",
            [
                ":id" => $genreId,
            ]
        );
    }

    public function findByGenreDesignation(string $genre)
    {
        return $this->sql->select(
            "SELECT *FROM genre WHERE designation = :designation",
            [
                ":designation" => $genre
            ]
        );
    }
}
