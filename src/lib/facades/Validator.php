<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 15/09/18
 * Time: 23:22
 */

namespace Qui\lib\facades;


/**
 * Class Validator
 * @package Qui\core\facades\
 *
 *
 *
 */
class Validator extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'validator';
    }
}