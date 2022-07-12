<?php

define("BASE_URL", "http://localhost/library/");

function redirect($file, $presets = "", $dir = "templates")
{
    if (empty($dir)) {
        header("location: " . BASE_URL . $file . ".php" . $presets);
        exit;
    }

    header("location: " . BASE_URL . $dir . DIRECTORY_SEPARATOR . $file . ".php" . $presets);
    exit;
}
