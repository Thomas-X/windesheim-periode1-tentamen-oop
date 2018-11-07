<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 06/11/18
 * Time: 14:39
 */

namespace Qui\lib;


use ErrorException;

class SuperSeriousErrorLogger
{
    /*
     * An error logger that logs _everything_
     * Use this as a last resort :). Or if you're debugging without a stacktrace (i.e server)
     * */
    public static function  enableErrorLogging(bool $enableErrorHandler) {
        if ($enableErrorHandler == true) {
            set_error_handler(function ($errno, $errstr, $errfile, $errline) {
                var_dump(new ErrorException($errstr, $errno, 0, $errfile, $errline));
            });
        }
        register_shutdown_function(function () {
            $err = error_get_last();
            if (!is_null($err)) {
                var_dump($err);
                print 'Error#' . $err['message'] . '<br>';
                print 'Line#' . $err['line'] . '<br>';
                print 'File#' . $err['file'] . '<br>';
            }
        });
    }
}