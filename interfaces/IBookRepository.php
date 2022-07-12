<?php

namespace interfaces;

use entities\Book;

interface IBookRepository
{
    public function save(Book $book);
    public function update(Book $book);

    public function get();

    public function delete(int $bookId);
    public function findById(int $bookId);

    public function findByBookGenreAndAuthor(string $book, int $genreId, int $authorId);
}
