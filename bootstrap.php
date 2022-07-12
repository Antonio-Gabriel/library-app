<?php

use common\Application;

Application::setAlias(
    "@root",
    __DIR__
        . DIRECTORY_SEPARATOR .
        "templates" .
        DIRECTORY_SEPARATOR
);
