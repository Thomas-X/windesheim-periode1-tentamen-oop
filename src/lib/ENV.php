<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/09/18
 * Time: 19:33
 */

namespace Qui\lib;

/*
 * This class is used to load the .env files that store various confidential data like database passwords
 * .env is ignored in .gitignore
 * */
class ENV
{
    public static function setup()
    {
        static::load();
    }

    public static function load()
    {
        $str = file_get_contents(__DIR__ . '/../../.env');
        $str = explode("\n", $str);
        foreach ($str as $value) {
            $keypair = explode('=', $value);

            if (strlen($keypair[0]) > 0) {
                if (strlen($keypair[1]) <= 0) {
                    $keypair[1] = null;
                }
                $_ENV[$keypair[0]] = trim($keypair[1]);
            }
        };

    }
}