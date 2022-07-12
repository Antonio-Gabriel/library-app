<?php

require_once "../index.php";

use configs\Model;
use entities\Genre;
use services\GenreService;

class EditGenreController extends Model
{
    private GenreService $genreService;

    public function __construct($request)
    {
        $this->setData($request);
        $this->genreService = new GenreService();
    }

    public function handle()
    {
        $genre = Genre::create($this->getdesignation(), intval($this->getid()));

        $genreAlreadyExists = $this->genreService->findByGenreDesignation(
            $this->getdesignation()
        );

        if ($genreAlreadyExists) {
            redirect("editGenre", "?status=400&error=Genre already exists&designation={$this->getdesignation()}");
        }

        $result = $this->genreService->update($genre->getValue());

        if ($result) {
            redirect("genre", "?status=200&msg=Genre `{$this->getdesignation()}` successfully updated");
        }

        redirect("genre", "?status=400&error=An error occurred, please try again!");
    }
}

(new EditGenreController($_POST))->handle();
