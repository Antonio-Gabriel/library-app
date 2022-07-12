<?php

namespace services;

use configs\Sql;
use entities\Book;
use interfaces\IBookRepository;

class BookService implements IBookRepository
{
    private Sql $sql;

    public function __construct()
    {
        $this->sql = new Sql();
    }

    public function save(Book $book)
    {
        return $this->sql->query(
            "INSERT INTO book (title, description, author_id, genre_id) 
             VALUES (:title, :description, :author_id, :genre_id)",
            [
                ":title" => $book->props->title,
                ":description" => $book->props->description,
                ":author_id" => $book->props->authorId,
                ":genre_id" => $book->props->genreId
            ]
        );
    }

    public function update(Book $book)
    {
        return $this->sql->query(
            "UPDATE book 
             SET title = :title, description = :description, 
             author_id = :author_id, genre_id = :genre_id WHERE id = :id",
            [
                ":id" => $book->getId(),
                ":title" => $book->props->title,
                ":description" => $book->props->description,
                ":author_id" => $book->props->authorId,
                ":genre_id" => $book->props->genreId
            ]
        );
    }

    public function get()
    {
        return $this->sql->select(
            "SELECT 
            b.id, b.title, b.description, a.name, 
            g.designation, b.created_at, b.updated_at
            FROM book b 
            LEFT JOIN author a ON b.author_id = a.id 
            LEFT JOIN genre g ON b.genre_id = g.id"
        );
    }

    public function findByBookGenreAndAuthor(string $book, int $genreId, int $authorId)
    {
        return $this->sql->select(
            "SELECT *FROM book WHERE title = :title AND author_id = :author_id AND genre_id = :genre_id",
            [
                ":title" => $book,
                ":genre_id" => $genreId,
                ":author_id" => $authorId
            ]
        );
    }

    public function delete(int $bookId)
    {
        return $this->sql->query(
            "DELETE FROM book WHERE id = :id",
            [
                ":id" => $bookId,
            ]
        );
    }

    public function findById(int $bookId)
    {
        return $this->sql->select(
            "SELECT 
            b.id, b.title, b.description, a.name, a.id as 'author_id', 
            g.designation, g.id as 'genre_id', b.created_at, b.updated_at 
            FROM book b 
            LEFT JOIN author a ON b.author_id = a.id 
            LEFT JOIN genre g ON b.genre_id = g.id;",
            [
                ":id" => $bookId
            ]
        );
    }
}
