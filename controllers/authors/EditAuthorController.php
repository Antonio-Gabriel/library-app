<?php

require_once "../index.php";

use configs\Model;
use entities\Author;
use services\AuthorService;

class EditAuthorController extends Model
{
    private AuthorService $authorService;

    public function __construct($request)
    {
        $this->setData($request);
        $this->authorService = new AuthorService();
    }

    public function handle()
    {
        $author = Author::create($this->getname(), intval($this->getid()));

        $authorAlreadyExists = $this->authorService->findByAuthorName(
            $this->getname()
        );

        if ($authorAlreadyExists) {
            redirect("editAuthor", "?status=400&error=Author already exists&name={$this->getname()}");
        }

        $result = $this->authorService->update($author->getValue());

        if ($result) {
            redirect("author", "?status=200&msg=Author `{$this->getname()}` successfully updated");
        }

        redirect("author", "?status=400&error=An error occurred, please try again!");
    }
}

(new EditAuthorController($_POST))->handle();
