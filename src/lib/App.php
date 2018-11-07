<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 15/09/18
 * Time: 16:22
 */

namespace Qui\lib;

use Qui\core\BoundMethodWrapper;


/*
 *  A simple DI container named App.
 * */

/**
 * Class App
 * @package Qui\core
 */
class App
{
    public const GET = 'GET';
    public const POST = 'POST';
    public const REACT_APP_COMPONENTS = [
        'forum-home' => 'forum-home'
    ];

    private static $registry = [];
    // tmp scoping variable for 'monkey' patching a bound method
    private static $val;

    // TODO hello world

    /**
     * @param $key
     * @param $value
     */
    public static function bind($key, $value)
    {
        static::$registry[$key] = $value;
    }



    /*
     * creates an anonymous function out of a method. (currently unused after facades, could be used in the future so not removing)
     * */
    /**
     * @param string $key
     * @param $methodName
     * @param $classNamespaced
     */
    public static function bindMethod(string $key, $methodName, $classNamespaced)
    {
        static::$registry[$key] = [
            'method' => $methodName,
            'class' => $classNamespaced
        ];
    }

    /*
     * get a key value stored in the $registry static
     * */
    /**
     * @param $key
     * @return mixed|\Qui\core\BoundMethodWrapper
     * @throws \Exception
     */
    public static function get($key)
    {
        if (!array_key_exists($key, static::$registry)) {
            throw new \Exception("{$key} not found in App DI container, did you remove a required dependency?");
        }
        static::$val = static::$registry[$key];
        // If is a method binding
        if (gettype(static::$val) == 'array' && array_key_exists('method', static::$val) && array_key_exists('class', static::$val)) {
            return (new BoundMethodWrapper(static::$val['method'], static::$val['class']));
        }

        return static::$registry[$key];
    }

    /*
     * map through dependencies given in public/index.php and check for required values
     * */
    /**
     * @param $deps
     * @throws \Exception
     */
    public static function setupDependencies($deps)
    {
        // Bind dependencies to DI container
        foreach ($deps as $key => $dep) {
            App::bind($key, $dep);
        }
        $requireds = ['view', 'database', 'validator', 'router'];
        foreach ($requireds as $required) {
            // let it throw an error if key is undefined
            static::get($required);
        }
    }

    /*
     *
     * */
    public static function setupENV()
    {
        ENV::setup();
    }


    /*
     *  require the web.php so the routes get added
     * */
    public static function setupRoutes($relativeRoutesPath)
    {
        require $relativeRoutesPath;
    }

    /*
     *  grab the router from the internal registry and serve
     * */
    public static function run()
    {
        static::$registry['router']->serve();
    }

    public static function isDevelopmentEnviroment()
    {
        return static::_checkEnv("development");
    }

    private static function _checkEnv($_env)
    {
        $env = $_ENV['ENVIROMENT'];
        if (!$env) {
            throw new Exception ("Key ENVIROMENT not set in .env file. Set it to development or production depending on the enviroment");
        }
        if ($env == $_env) {
            return true;
        }
        return false;
    }

    public static function isProductionEnviroment()
    {
        return static::_checkEnv("production");
    }
}