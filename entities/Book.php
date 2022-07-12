<?php

namespace entities;

use common\{Entity, Result};

class Book extends Entity
{
    private function __construct($props, ?int $id = null)
    {
        parent::__construct($props, $id);
    }

    public static function create(string $title, int $genreId, int $authorId, string $description, ?int $id = null)
    {
        if (empty($title)) {
            return Result::Fail("Please, input a valid title!");
        }

        if (!$genreId || !$authorId) {
            return Result::Fail("Please, select a valid genre or author!");
        }

        $book = new Book(
            (object)[
                "title" => trim($title),
                "genreId" => $genreId,
                "authorId" => $authorId,
                "description" => trim($description)
            ],
            $id
        );

        return Result::Ok($book);
    }
}
