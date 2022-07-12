<?php

namespace common;

use Exception;

class Application
{
    protected static $alias = [];

    protected static $config;

    public static function setAlias(string $alias, string $path)
    {
        self::$alias[$alias] = $path;
    }

    public static function getAlias(string $alias)
    {
        if (!isset(self::$alias[$alias])) {
            throw new Exception("Path to \"$alias\" not found", 500);
        }

        return self::$alias[$alias];
    }
}
