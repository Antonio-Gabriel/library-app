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

$genre = new GenreService();
$genres = $genre->get();

?>

<?php
$title = "Genre";
require_once "shared/header.php";
?>

<?php
$pageTitle = "Genre Property";
require_once "shared/navbar.php";
?>


<section class="content-page-title mb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                <h2>Genre list (<?= count($genres) ?>)</h2>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 d-flex justify-content-end">
                <button data-bs-toggle="modal" data-bs-target="#createAuthorModal">
                    <img src="/library/assets/icons/Plus.png" alt="plus icon">
                    Add Genre
                </button>
            </div>
        </div>
    </div>
</section>

<section class="list">
    <div class="container">
        <div>
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
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($genres as $key => $value) : ?>
                        <tr>
                            <td data-label="#"><?= $key + 1 ?></td>
                            <td data-label="Title:"><?= $value["designation"] ?></td>
                            <td data-label="Created At:"><?= date("M j, Y - h:m:s", strtotime($value["created_at"])) ?></td>
                            <td data-label="Updated At:"><?= date("M j, Y - h:m:s", strtotime($value["updated_at"])) ?></td>
                            <td data-label="" class="d-flex justify-content-end">
                                <ul class="m-0 p-0 d-flex align-items-center actions-edit">
                                    <li>
                                        <a href="<?= to("editGenre", "templates", "?designation={$value['designation']}") ?>">
                                            <img src="/library/assets/icons/Edit.png" alt="edit icon">
                                        </a>
                                    </li>
                                    <li>
                                        <a onclick="return confirm('Are you sure?');" href="<?= to("DeleteGenreController", "controllers/genre", "?genre_id={$value['id']}") ?>">
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

<!-- Modal -->
<div class="modal fade" id="createAuthorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createAuthorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAuthorModalLabel">Register genre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="<?= to("SaveGenreController", "controllers/genre") ?>" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name: </label>
                        <input type="text" class="form-control" id="name" name="designation" placeholder="ex: drama, comedy">
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