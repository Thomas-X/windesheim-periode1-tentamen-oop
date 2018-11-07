<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 15/09/18
 * Time: 23:17
 */

namespace Qui\lib\facades;

/**
 * Class DB_PDO
 * @package Qui\core\facades
 */
class DB_PDO extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'pdo';
    }
}