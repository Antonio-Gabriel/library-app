<?php

session_start();

require_once "./utils/to.php";
@require_once "./utils/redirect.php";

require_once "./middleware/security/Authorization.php";

use middleware\security\Authorization;

Authorization::isAuthorizated();
?>

<?php
$title = "SignIn";
require_once "shared/header.php";
?>

<main class="signIn-wrapper overflow-hidden">
    <div class="row g-0">
        <div class="col-lg-8 col-md-7">
            <img src="/library/assets/imgs/library-background-2.jpg" alt="library background">
        </div>
        <div class="col-lg-4 col-md-5 py-5">
            <div class="container px-4">
                <header>
                    <a href="/library/index.php" class="logo">Library.App</a>
                </header>

                <div class="content">
                    <div class="description">
                        <h1>Log in to use the application</h1>
                        <p>Fill in the required fields properly to authenticate yourself</p>
                    </div>

                    <form action="<?= to("UserController", "controllers") ?>" class="mt-2" method="post">

                        <?php if (isset($_GET["status"])) : ?>
                            <?php if (intval($_GET["status"]) === 400 || intval($_GET["status"]) === 404) : ?>
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

                        <div class="mb-2">
                            <label for="email" class="form-label">Email address: </label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password: </label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="your password" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Sign In
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once "shared/footer.php"; ?>