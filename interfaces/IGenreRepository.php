<?php

namespace interfaces;

use entities\Genre;

interface IGenreRepository
{
    public function save(Genre $genre);
    public function update(Genre $genre);

    public function get();

    public function delete(int $genreId);
    public function findByGenreDesignation(string $genre);
}
