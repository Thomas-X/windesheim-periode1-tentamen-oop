<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 02/10/18
 * Time: 11:43
 */

namespace Qui\lib\facades;

use Qui\lib\facades\Facade;

class Mailer extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mailer';
    }
}