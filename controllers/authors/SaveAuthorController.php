<?php

require_once "../index.php";

use configs\Model;
use entities\Author;
use services\AuthorService;

class SaveAuthorController extends Model
{
    private AuthorService $authorService;

    public function __construct($request)
    {
        $this->setData($request);
        $this->authorService = new AuthorService();
    }

    public function handle()
    {
        $author = Author::create($this->getname());

        if (
            $error = $author->errorValue()
        ) {
            redirect("author", "?status=400&error={$error}");
        }

        $authorAlreadyExists = $this->authorService->findByAuthorName(
            $this->getname()
        );

        if ($authorAlreadyExists) {
            redirect("author", "?status=400&error=Author already exists, please try other");
        }

        $result = $this->authorService->save($author->getValue());

        if ($result) {
            redirect("author", "?status=200&msg=Author successfully created");
        }

        redirect("author", "?status=400&error=An error occurred, please try again!");
    }
}

(new SaveAuthorController($_POST))->handle();
