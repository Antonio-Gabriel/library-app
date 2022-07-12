<?php

session_start();

require_once "../utils/to.php";
@require_once "../utils/redirect.php";

require_once "../middleware/security/Authorization.php";

use middleware\security\Authorization;

Authorization::notAuthorizated();

require_once "../configs/Sql.php";
require_once "../interfaces/IAuthorRepository.php";
require_once "../services/AuthorService.php";

use services\AuthorService;

if (!isset($_GET["name"]) || empty($_GET["name"])) {
    redirect("author", "?status=400&error=Invalid author");
}

$author = new AuthorService();
$selectedAuthor = $author->findByAuthorName(
    $_GET["name"]
);

if (!$selectedAuthor) {
    redirect("author", "?status=400&error=Invalid author");
}

?>

<?php
$title = "Author";
require_once "shared/header.php";
?>

<?php
$pageTitle = "Edit Author";
$redirectTo = "author.php";
require_once "shared/navbar.php";
?>


<section class="content-page-title mb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Edit Author</h2>
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
        <form action="<?= to("EditAuthorController", "controllers/authors") ?>" method="post">
            <input type="hidden" name="id" value="<?= $selectedAuthor[0]["id"] ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name: </label>
                <input type="text" class="form-control" id="name" value="<?= $selectedAuthor[0]["name"] ?>" name="name" placeholder="ex: john doe" required>
            </div>

            <button type="submit" class="btn btn-primary">
                Edit
            </button>
        </form>
    </div>
</section>

<?php require_once "shared/footer.php"; ?>