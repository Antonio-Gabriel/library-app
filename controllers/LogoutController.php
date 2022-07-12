<?php

require_once "./index.php";

class LogoutController
{
    public function logout()
    {
        // Logout
        session_start();
        session_regenerate_id();

        session_destroy();

        unset($_SESSION["user"]);

        redirect("index", "", "");
    }
}

(new LogoutController())->logout();
