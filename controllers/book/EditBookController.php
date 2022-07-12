<?php

require_once "../index.php";

use configs\Model;
use entities\Book;
use services\BookService;

class EditBookController extends Model
{
    private BookService $bookService;

    public function __construct($request)
    {
        $this->setData($request);
        $this->bookService = new BookService();
    }

    public function handle()
    {
        $book = Book::create($this->gettitle(), $this->getgenre(), $this->getauthor(), $this->getdescription(), $this->getid());

        $bookAlreadyExists = $this->bookService->findByBookGenreAndAuthor(
            $this->gettitle(),
            $this->getgenre(),
            $this->getauthor()
        );

        if ($bookAlreadyExists) {
            redirect("editBook", "?status=400&error=Book already exists on this genre and author&book_id={$this->getid()}");
        }

        $result = $this->bookService->update($book->getValue());

        if ($result) {
            redirect("home", "?status=200&msg=Book `{$this->gettitle()}` successfully updated");
        }

        redirect("home", "?status=400&error=An error occurred, please try again!");
    }
}

(new EditBookController($_POST))->handle();
