<?php

session_start();

require_once "../utils/to.php";
@require_once "../utils/redirect.php";

require_once "../middleware/security/Authorization.php";

use middleware\security\Authorization;

Authorization::notAuthorizated();


require_once "../configs/Sql.php";

require_once "../interfaces/IGenreRepository.php";
require_once "../interfaces/IAuthorRepository.php";
require_once "../interfaces/IBookRepository.php";

require_once "../services/GenreService.php";
require_once "../services/AuthorService.php";
require_once "../services/BookService.php";

use services\AuthorService;
use services\BookService;
use services\GenreService;

$genre = new GenreService();
$genres = $genre->get();


$author = new AuthorService();
$authors = $author->get();

$book = new BookService();
$books = $book->get();

?>

<?php
$title = "Dashboard";
require_once "shared/header.php";
?>


<header class="dashboard">
    <nav class="navbar navbar-expand-md">
        <div class="container">
            <a class="navbar-brand d-flex flex-column" href="home.php">
                Library.App
                <span>Manage yours books</span>
            </a>
            <button class="navbar-toggler m-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">Manu</span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="home.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="author.php">Authors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="genre.php">Genres</a>
                    </li>
                </ul>
                <div class="user-info d-flex align-items-center">
                    <div class="info d-flex justify-content-center flex-column">
                        <h5 class="m-0 p-0"><?= $_SESSION["user"]["name"] ?></h5>
                        <span>Manager</span>
                    </div>
                    <a class="logout ml-2" href="<?= to("LogoutController", "controllers") ?>">
                        <img src="/library/assets/icons/Logout.png" alt="logout icon">
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>

<section class="actions-by-review">
    <div class="container d-flex align-items-center justify-content-between">
        <ul class="d-flex align-items-center p-0 m-0">
            <li class="d-flex flex-column">
                <strong><?= count($books) ?></strong>
                <span>Total Books</span>
            </li>
            <li class="d-flex flex-column">
                <strong><?= count($genres) ?></strong>
                <span>Total Genre</span>
            </li>
            <li class="d-flex flex-column">
                <strong><?= count($authors) ?></strong>
                <span>Total Authors</span>
            </li>
        </ul>

        <div>
            <button data-bs-toggle="modal" data-bs-target="#createTaskModal">
                <img src="/library/assets/icons/Plus.png" alt="plus icon">
                Add Book
            </button>
        </div>
    </div>
</section>

<main class="content-wrapper">
    <section class="books">
        <div class="container">
            <div class="books-title">
                <h2>Book list</h2>
            </div>

            <div style="overflow-x:auto;">

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

                <table class="align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Genre</th>
                            <th>Author</th>
                            <th>Launched in</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $key => $value) : ?>
                            <tr>
                                <td data-label="#"><?= $key + 1 ?></td>
                                <td data-label="Title:"><?= $value['title'] ?></td>
                                <td data-label="Genre:"><?= $value['designation'] ?></td>
                                <td data-label="Author:"><?= $value['name'] ?></td>
                                <td data-label="Launched in:"><?= date("M j, Y - h:m:s", strtotime($value["created_at"])) ?></td>
                                <td data-label="" class="d-flex justify-content-end">
                                    <ul class="m-0 p-0 d-flex align-items-center actions-edit">
                                        <li>
                                            <a href="<?= to("editBook", "templates", "?book_id={$value['id']}") ?>">
                                                <img src="/library/assets/icons/Edit.png" alt="edit icon">
                                            </a>
                                        </li>
                                        <li>
                                            <a onclick="return confirm('Are you sure?');" href="<?= to("DeleteBookController", "controllers/book", "?book_id={$value['id']}") ?>">
                                                <img src="/library/assets/icons/trach.png" alt="trach icon">
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<!-- Modal -->
<div class="modal fade" id="createTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTaskModalLabel">Register book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= to("SaveBookController", "controllers/book") ?>" method="post">
                    <div class="mb-2">
                        <label for="title" class="form-label">Title *: </label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="ex: John doe">
                    </div>

                    <div class="mb-2">
                        <label for="genre" class="form-label">Genhre *: </label>
                        <select class="form-select" id="genre" name="genre" aria-label="Default select example">
                            <option value="0" selected>Select a genre</option>
                            <?php foreach ($genres as $value) : ?>
                                <option value="<?= $value["id"] ?>"><?= $value["designation"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="author" class="form-label">Author *: </label>
                        <select class="form-select" id="author" name="author" aria-label="Default select example">
                            <option value="0" selected>Seleca an author</option>
                            <?php foreach ($authors as $value) : ?>
                                <option value="<?= $value["id"] ?>"><?= $value["name"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description: </label>
                        <textarea rows="4" class="form-control" id="description" name="description"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require_once "shared/footer.php"; ?>