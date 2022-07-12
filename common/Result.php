<?php

namespace common;

use Exception;

class Result
{
    private bool $IS_SUCCESS;
    private $ERROR;
    private $VALUE;

    private function __construct(
        bool $is_success,
        $error = null,
        $value = null
    ) {
        $this->IS_SUCCESS = $is_success;
        $this->ERROR = $error;
        $this->VALUE = $value;

        if (
            $this->IS_SUCCESS === true && $this->ERROR === true
        ) {
            throw new Exception("InvalidOperation: A result connot be successful and contain an error");
        }

        if (
            $this->IS_SUCCESS === false && $this->ERROR === false
        ) {
            throw new Exception("InvalidOperation: A failing result needs to contain an error message");
        }
    }

    public function getValue()
    {
        if ($this->IS_SUCCESS === false) {
            throw new Exception("Can't get the value of an error result. Use `errorValue` instead.");
        }

        return $this->VALUE;
    }

    public function errorValue()
    {
        return $this->ERROR;
    }


    public static function Ok($value): self
    {
        // Return status OK
        return new Result(true, null, $value);
    }

    public static function Fail($error): self
    {
        // Return status fail
        return new Result(false, $error);
    }
}
