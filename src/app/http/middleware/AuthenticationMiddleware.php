<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 02/10/18
 * Time: 21:24
 */

namespace Qui\app\http\middleware;


use Qui\lib\facades\Authentication;
use Qui\lib\facades\DB;
use Qui\lib\Request;
use Qui\lib\Response;

class AuthenticationMiddleware
{
    /**
     * Test comments
     * @param Request $req
     * @param Response $res
     * @return bool
     */
    public function shouldNotBeLoggedIn(Request $req, Response $res)
    {
        return !$this->shouldBeLoggedIn($req, $res);
    }

    public function shouldBeLoggedIn(Request $req, Response $res)
    {
        if (Authentication::verify()) {
            return true;
        }
        return false;
    }

    public function resetPassword(Request $req, Response $res)
    {
        $forgotPasswordToken = $req->params['forgotPasswordToken'] ?? null;
        if (!isset($forgotPasswordToken)) {
            return false;
        }
        $users = DB::selectWhere('forgotPasswordToken', 'users', 'forgotPasswordToken', $forgotPasswordToken) ?? null;
        if (!isset($users)) {
            return false;
        } else if (count($users) > 1) {
            return false;
        }
        return true;
    }
}