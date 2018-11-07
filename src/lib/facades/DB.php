<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 15/09/18
 * Time: 23:14
 */

namespace Qui\lib\facades;

/**
 * Class DB
 * @package Qui\core\facades
 */
class DB extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'database';
    }
}