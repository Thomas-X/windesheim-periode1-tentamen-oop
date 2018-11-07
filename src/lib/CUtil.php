<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 15/09/18
 * Time: 16:43
 */

namespace Qui\lib;


/**
 * Class Util
 * @package Qui\core
 */
class CUtil
{

    /*
     * Simple dump and die function, idea stolen from laravel :)
     * */
    /**
     * @param $value
     * @param null $extraValues
     */
    public function dd($value, $extraValues = null)
    {
        $args = func_get_args();
        if ($args > 1) {
            foreach ($args as $index => $argv) {
                var_dump($argv);
            }
        } else {
            var_dump($value);
        }
        die;
    }
}