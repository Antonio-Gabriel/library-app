<?php

define("BASE_URL", "http://localhost/library/");

function to($file, $dir = "templates", $presets = "")
{
    return  BASE_URL . $dir . DIRECTORY_SEPARATOR . $file . ".php" . $presets;
}
