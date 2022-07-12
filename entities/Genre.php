<?php

namespace entities;

use common\{Entity, Result};

class Genre extends Entity
{
    private function __construct($props, ?int $id = null)
    {
        parent::__construct($props, $id);
    }

    public static function create(string $designation, ?int $id = null)
    {
        if (empty($designation)) {
            return Result::Fail("Please, input a valid designation name!");
        }

        $genre = new Genre((object)["designation" => trim($designation)], $id);

        return Result::Ok($genre);
    }
}
