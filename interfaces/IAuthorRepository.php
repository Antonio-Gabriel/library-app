<?php

namespace interfaces;

use entities\Author;

interface IAuthorRepository
{
    public function save(Author $author);
    public function update(Author $author);

    public function get();

    public function delete(int $authorId);
    public function findByAuthorName(string $name);
}
