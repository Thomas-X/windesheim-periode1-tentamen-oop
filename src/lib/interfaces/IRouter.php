<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 12/09/18
 * Time: 14:35
 */

namespace Qui\lib\interfaces;


/**
 * Interface IRouter
 * @package Qui\interfaces
 */
interface IRouter
{
    public function serve () : void;

    /**
     * @param array $middlewares
     * @param array $routes
     */
    public function middleware (array $middlewares, array $routes) : void;
}