<?php

require_once "../index.php";

use configs\Model;
use entities\Book;
use services\BookService;

class SaveBookController extends Model
{
    private BookService $bookService;

    public function __construct($request)
    {
        $this->setData($request);
        $this->bookService = new BookService();
    }

    public function handle()
    {
        $book = Book::create($this->gettitle(), $this->getgenre(), $this->getauthor(), $this->getdescription());

        if (
            $error = $book->errorValue()
        ) {
            redirect("home", "?status=400&error={$error}");
        }

        $bookAlreadyExists = $this->bookService->findByBookGenreAndAuthor(
            $this->gettitle(),
            $this->getgenre(),
            $this->getauthor()
        );

        if ($bookAlreadyExists) {
            redirect("home", "?status=400&error=Book already exists on this genre and author");
        }

        $result = $this->bookService->save($book->getValue());

        if ($result) {
            redirect("home", "?status=200&msg=Book successfully created");
        }

        redirect("home", "?status=400&error=An error occurred, please try again!");
    }
}

(new SaveBookController($_POST))->handle();
