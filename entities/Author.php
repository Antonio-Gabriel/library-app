<?php

namespace entities;

use common\{Entity, Result};

class Author extends Entity
{
    private function __construct($props, ?int $id = null)
    {
        parent::__construct($props, $id);
    }

    public static function create(string $name, ?int $id = null)
    {
        if (empty($name)) {
            return Result::Fail("Please, input a valid name!");
        }

        $author = new Author((object)["name" => trim($name)], $id);

        return Result::Ok($author);
    }
}
