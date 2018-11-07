<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/09/18
 * Time: 00:52
 */

namespace Qui\lib;

/*
 * A class that contains certain methods for ease of use, redirecting, returning json and the likes
 * */

/**
 * Class Response
 * @package Qui\core
 */
class Response
{

    public function __construct()
    {

    }


    /**
     * @param $object
     * @return false|string
     */
    public function json($object)
    {
        return json_encode($object, JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $path
     * @param int $code
     * @param bool $permanent
     */
    public function redirect($path, $code = 302, $permanent=false)
    {
        http_response_code($permanent ? 301 : $code);
        header("Location: {$path}");
        // to avoid further logic after redirect
        exit();
    }
}