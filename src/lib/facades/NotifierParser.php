<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/10/18
 * Time: 00:11
 */

namespace Qui\lib\facades;

use Qui\lib\facades\Facade;

class NotifierParser extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'notifierparser';
    }
}