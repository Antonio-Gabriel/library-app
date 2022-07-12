<?php

require_once "../index.php";

use configs\Model;
use services\BookService;

class DeleteBookController extends Model
{
    private BookService $bookService;

    public function __construct()
    {
        $this->bookService = new BookService();
    }

    public function handle()
    {
        $result = $this->bookService->delete(intval($_GET["book_id"]));

        if ($result) {
            redirect("home", "?status=200&msg=Book successfully deleted");
        }

        redirect("home", "?status=400&error=Operation canceled");
    }
}

(new DeleteBookController())->handle();
