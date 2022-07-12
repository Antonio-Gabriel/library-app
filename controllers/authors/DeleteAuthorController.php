<?php

require_once "../index.php";

use configs\Model;
use services\AuthorService;

class DeleteAuthorController extends Model
{
    private AuthorService $authorService;

    public function __construct()
    {
        $this->authorService = new AuthorService();
    }

    public function handle()
    {
        $result = $this->authorService->delete(intval($_GET["author_id"]));

        if ($result) {
            redirect("author", "?status=200&msg=Author successfully deleted");
        }

        redirect("author", "?status=400&error=Operation canceled");
    }
}

(new DeleteAuthorController())->handle();
