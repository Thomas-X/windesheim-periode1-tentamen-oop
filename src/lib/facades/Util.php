<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 15/09/18
 * Time: 23:18
 */

namespace Qui\lib\facades;


/**
 * Class Util
 * @package Qui\core\facades
 */
class Util extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'util';
    }
}