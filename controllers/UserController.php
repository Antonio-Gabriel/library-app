<?php

require_once "./index.php";

use configs\Model;
use services\UserService;
use middleware\security\Hash;

class UserController extends Model
{
    private UserService $userService;

    public function __construct($request)
    {
        $this->setData($request);
        $this->userService = new UserService();
    }

    public function authenticate()
    {
        // The focus of this controller is authenticated the user!

        $user = $this->userService->findByEmail($this->getemail())[0];

        if (!$user) {
            redirect("index", "?status=404&error=Account not exists!", "");
        }

        if (
            !Hash::compare($this->getpassword(), $user["password"])
        ) {
            redirect("index", "?status=400&error=Invalid email or password!", "");
        }

        session_start();
        session_regenerate_id();

        $_SESSION["user"] = $user;

        redirect("home");
    }

    public function register()
    {
        // Seed for create defaul user of app
        $result = $this->userService->save("Library App", "libraryapp@online.com", Hash::encrypt("library-app"));
        if ($result) {
            echo "Created";
        }
    }
}

(new UserController($_POST))->authenticate();
