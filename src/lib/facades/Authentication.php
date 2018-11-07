<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/09/18
 * Time: 19:47
 */

namespace Qui\lib\facades;


class Authentication extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'authentication';
    }
}