<?php

require_once "../index.php";

use configs\Model;
use entities\Genre;
use services\GenreService;

class SaveGenreController extends Model
{
    private GenreService $genreService;

    public function __construct($request)
    {
        $this->setData($request);
        $this->genreService = new GenreService();
    }

    public function handle()
    {
        $genre = Genre::create($this->getdesignation());

        if (
            $error = $genre->errorValue()
        ) {
            redirect("genre", "?status=400&error={$error}");
        }

        $genreAlreadyExists = $this->genreService->findByGenreDesignation(
            $this->getdesignation()
        );

        if ($genreAlreadyExists) {
            redirect("genre", "?status=400&error=Genre already exists, please try other");
        }

        $result = $this->genreService->save($genre->getValue());

        if ($result) {
            redirect("genre", "?status=200&msg=Genre successfully created");
        }

        redirect("genre", "?status=400&error=An error occurred, please try again!");
    }
}

(new SaveGenreController($_POST))->handle();
