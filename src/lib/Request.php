<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/09/18
 * Time: 00:19
 */

namespace Qui\lib;

/*
 * This is (mostly) just a simple wrapper around super globals, so code
 * is easier manageable / testable, nothing special going on here
 * */

/**
 * Class Request
 * @package Qui\core
 */
class Request
{
    public $params;
    public $cookies;
    public $server;
    public $headers;
    public $files;
    public $secure;
    public $method;
    public $body;

    public function __construct()
    {
        $this->setParams();
        $this->setCookies();
        $this->setServer();
//        $this->setHeaders();
        $this->setFiles();
        $this->setSecure();
        $this->setMethod();
        $this->setBody();
    }

    private function setParams()
    {
        $this->params = array_merge($_GET, $_POST);
    }

    private function setCookies()
    {
        $this->cookies = $_COOKIE;
    }

    private function setServer()
    {
        $this->server = $_SERVER;
    }
//    /**
//     * @return array
//     */
//    /**
//     * @return array
//     */
    private static function getHeaders()
    {
        /*
         * stolen from stackoverflow, getallheaders isn't supported in a fastcgi enviroment
         * */
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }

    private function setHeaders()
    {
        $this->headers = Request::getHeaders();
    }

    private function setFiles()
    {
        $this->files = $_FILES;
    }

    private function setSecure()
    {
        // https://stackoverflow.com/a/47753742
        // ==> im lazy, this should figure out HTTPS
        $getSecureStatus = function () {
            if (array_key_exists("HTTPS", $_SERVER) && 'on' === $_SERVER["HTTPS"]) {
                return true;
            }
            if (array_key_exists("SERVER_PORT", $_SERVER) && 443 === (int)$_SERVER["SERVER_PORT"]) {
                return true;
            }
            if (array_key_exists("HTTP_X_FORWARDED_SSL", $_SERVER) && 'on' === $_SERVER["HTTP_X_FORWARDED_SSL"]) {
                return true;
            }
            if (array_key_exists("HTTP_X_FORWARDED_PROTO", $_SERVER) && 'https' === $_SERVER["HTTP_X_FORWARDED_PROTO"]) {
                return true;
            }
            return false;
        };
        $this->secure = $getSecureStatus();
    }

    private function setMethod()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    private function setBody()
    {
        $this->body = file_get_contents('php://input');
    }
}