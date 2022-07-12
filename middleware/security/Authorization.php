<?php

namespace middleware\security;

trait Authorization
{
    public static function notAuthorizated()
    {
        if (!isset($_SESSION['user'])) {
            redirect("index", "", "");
        }
    }

    public static function isAuthorizated()
    {
        if (isset($_SESSION['user'])) {
            redirect("home");
        }
    }
}
