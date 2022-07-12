<?php

require_once "./configs/autoload.php";
require_once "./bootstrap.php";
require_once "./utils/to.php";

use common\Application;

define(
    "VIEWS_PATH",
    Application::getAlias("@root")
);

require_once  VIEWS_PATH .  "signIn.php";
