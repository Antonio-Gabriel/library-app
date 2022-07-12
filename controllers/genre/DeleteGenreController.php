<?php

require_once "../index.php";

use configs\Model;
use services\GenreService;

class DeleteGenreController extends Model
{
    private GenreService $genreService;

    public function __construct()
    {
        $this->genreService = new GenreService();
    }

    public function handle()
    {
        $result = $this->genreService->delete(intval($_GET["genre_id"]));

        if ($result) {
            redirect("genre", "?status=200&msg=Genre successfully deleted");
        }

        redirect("genre", "?status=400&error=Operation canceled");
    }
}

(new DeleteGenreController())->handle();
