<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 12/09/18
 * Time: 19:23
 */

namespace Qui\lib\interfaces;


/**
 * Interface IMiddleware
 * @package Qui\interfaces
 */
interface IMiddleware
{
    /**
     * @return bool
     */
    public function next() : bool;
}