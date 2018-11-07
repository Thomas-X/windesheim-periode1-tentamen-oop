<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/11/18
 * Time: 11:40
 */

namespace Qui\app\http\middleware;


use Qui\lib\facades\Authentication;
use Qui\lib\Request;
use Qui\lib\Response;

/*
 * Middleware for checking if the user is an admin. aka meester Barista.
 * */
class MeesterBaristaMiddleware
{
    public function next(Request $req, Response $res) {
        $user = Authentication::verify(true);

        if ($user['roleid'] > 1) {
            return false;
        }
        return true;
    }
}