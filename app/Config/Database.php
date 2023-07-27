<?php

namespace App\Config;

class Database
{

    private static $credentials = [
        'hostname' => 'db',
        'username' => 'marcelo',
        'password' => '123',
        'database' => 'devboost_store',
        'port' => 3306,
    ];

    public static function connect()
    {
        return mysqli_connect(
            static::$credentials['hostname'],
            static::$credentials['username'],
            static::$credentials['password'],
            static::$credentials['database'],
            static::$credentials['port'],
        );
    }

    public static function close($mysqli) {
        mysqli_close($mysqli);
    }
}
