<?php

session_start();

require_once "../utils/to.php";
@require_once "../utils/redirect.php";

require_once "../middleware/security/Authorization.php";

use middleware\security\Authorization;

Authorization::notAuthorizated();

require_once "../configs/Sql.php";
require_once "../interfaces/IGenreRepository.php";
require_once "../services/GenreService.php";

use services\GenreService;

if (!isset($_GET["designation"]) || empty($_GET["designation"])) {
    redirect("genre", "?status=400&error=Invalid genre");
}

$genre = new GenreService();
$selectedGenre = $genre->findByGenreDesignation(
    $_GET["designation"]
);

if (!$selectedGenre) {
    redirect("genre", "?status=400&error=Invalid genre");
}

?>

<?php
$title = "Genre";
require_once "shared/header.php";
?>

<?php
$pageTitle = "Edit Genre";
$redirectTo = "genre.php";
require_once "shared/navbar.php";
?>


<section class="content-page-title mb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Edit Genre</h2>
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
        <form action="<?= to("EditGenreController", "controllers/genre") ?>" method="post">
            <input type="hidden" name="id" value="<?= $selectedGenre[0]["id"] ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name: </label>
                <input type="text" class="form-control" id="name" value="<?= $selectedGenre[0]["designation"] ?>" name="designation" placeholder="ex: drama, comedy" required>
            </div>

            <button type="submit" class="btn btn-primary">
                Edit
            </button>
        </form>
    </div>
</section>

<?php require_once "shared/footer.php"; ?>