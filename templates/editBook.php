<?php

session_start();

require_once "../utils/to.php";
@require_once "../utils/redirect.php";

require_once "../middleware/security/Authorization.php";

use middleware\security\Authorization;

Authorization::notAuthorizated();

require_once "../configs/Sql.php";

require_once "../interfaces/IBookRepository.php";
require_once "../services/BookService.php";

require_once "../interfaces/IGenreRepository.php";
require_once "../interfaces/IAuthorRepository.php";

require_once "../services/GenreService.php";
require_once "../services/AuthorService.php";

use services\BookService;

if (!isset($_GET["book_id"]) || empty($_GET["book_id"])) {
    redirect("home", "?status=400&error=Invalid book");
}

use services\AuthorService;
use services\GenreService;

$genre = new GenreService();
$genres = $genre->get();

$author = new AuthorService();
$authors = $author->get();

$book = new BookService();
$selectedBook = $book->findById(intval($_GET['book_id']));

if (!$selectedBook) {
    redirect("home", "?status=400&error=Invalid book");
}

?>

<?php
$title = "Book";
require_once "shared/header.php";
?>

<?php
$pageTitle = "Edit Book";
require_once "shared/navbar.php";
?>


<section class="content-page-title mb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Edit Book</h2>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <?php if (isset($_GET["status"])) : ?>
        <?php if (intval($_GET["status"]) === 400) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $_GET["error"] ?>
            </div>
        <?php endif; ?>

        <?php if (intval($_GET["status"]) === 200) : ?>
            <div class="alert alert-success" role="alert">
                <?= $_GET["msg"] ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<section class="edit-form">
    <div class="container">
        <form action="<?= to("EditBookController", "controllers/book") ?>" method="post">
            <input type="hidden" name="id" value="<?= $selectedBook[0]["id"] ?>">
            <div class="mb-2">
                <label for="title" class="form-label">Title *: </label>
                <input type="text" class="form-control" id="title" value="<?= $selectedBook[0]["title"] ?>" name="title" placeholder="ex: John doe">
            </div>

            <div class="mb-2">
                <label for="genre" class="form-label">Genhre *: </label>
                <select class="form-select" id="genre" name="genre" aria-label="Default select example">
                    <option value="<?= $selectedBook[0]["genre_id"] ?>" selected><?= $selectedBook[0]["designation"] ?></option>

                    <?php foreach (array_filter(
                        $genres,
                        fn ($value) => $value["designation"] !== $selectedBook[0]["designation"]
                    ) as $value) : ?>
                        <option value="<?= $value["id"] ?>"><?= $value["designation"] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-2">
                <label for="author" class="form-label">Author *: </label>
                <select class="form-select" id="author" name="author" aria-label="Default select example">
                    <option value="<?= $selectedBook[0]["author_id"] ?>" selected><?= $selectedBook[0]["name"] ?></option>

                    <?php foreach (array_filter(
                        $authors,
                        fn ($value) => $value["name"] !== $selectedBook[0]["name"]
                    ) as $value) : ?>
                        <option value="<?= $value["id"] ?>"><?= $value["name"] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description: </label>
                <textarea rows="4" cols="42" class="form-control" id="description" name="description">
                    <?= trim($selectedBook[0]["description"]) ?>
                </textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Edit
            </button>
        </form>
    </div>
</section>


<?php require_once "shared/footer.php"; ?>