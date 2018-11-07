<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/09/18
 * Time: 19:47
 */

namespace Qui\lib;


use phpDocumentor\Configuration\Merger\Annotation\Replace;
use Qui\lib\facades\DB;
use Qui\lib\facades\Util;

class CAuthentication
{
    // increase this when hardware can handle more salting rounds
    const SALTING_ROUNDS = 10;
    const HASHING_OPTIONS = [
        'cost' => CAuthentication::SALTING_ROUNDS
    ];

    public function login(Request $req, Response $res, string $email, string $password)
    {
        $user = $this->verifyCredentials($email, $password);
        if ($user['isValid'] == true) {
            // 1 week cookie time()+60*60*24*365 sec = 1 week
            // TODO enable secure option to avoi man-in-the-middle attacks
            if (App::isDevelopmentEnviroment()) {
                setcookie('token', $user['rememberMeToken'], time() + 60 * 60 * 24 * 7, Routes::$routes['home']);
            } else if (App::isProductionEnviroment()) {
                setcookie('token', $user['rememberMeToken'], time() + 60 * 60 * 24 * 7, Routes::$routes['home'], "", true);
            }
            $res->redirect(\Qui\lib\Routes::$routes['home'], 200);
        } else {
            $res->redirect(\Qui\lib\Routes::$routes['home'], 401);
        }
    }

    public function logout(Request $req, Response $res)
    {
        $token = $req->cookies['token'] ?? false;
        if (!$token) {
            // for some reason $res->redirect is undefined here, I can't be bothered
            header("Location: ". Routes::$routes['home']);
        } else {
            if (App::isDevelopmentEnviroment()) {
                setcookie('token', null, time() + 1, '/');
            } else if (App::isProductionEnviroment()) {
                setcookie('token', null, time() + 1, '/', "", true);
            }
            header("Location: " . Routes::$routes['home']);
        }
    }

    /*
     * generate random string based on the UNIX epoch timestamp and md5 hashing it
     * */
    public function generateRandomString()
    {
        return substr(str_shuffle(MD5(microtime())), 0, 99);
    }

    /*
     * not uniquely random (not researched at least) but since the chances of that are so abysmal its fine by me
     * */
    public function generateRandomHash()
    {
        // generate random string
        $str = $this->generateRandomString();
        return $this->generateHash((string) $str);
    }

    // TODO remove / refactor this (superadmin should only be able to do this)
    public function register($params)
    {
        // TODO check / validate parameters with Validator
        // TODO replace this token with a UUID
        try {
            $rememberMeToken = $this->generateRandomHash();
            DB::insertEntry('users', [
                'roleid' => 2,
                'fname' => $params['fname'],
                'lname' => $params['lname'],
                'email' => $params['email'],
                'mobile' => $params['mobile'],
                'password' => $this->generateHash($params['password']),
                'rememberMeToken' => $rememberMeToken,
            ]);
            return true;
        } catch (\Exception $exception) {
            Util::dd($exception);
            return false;
        }
    }

    public function verify($returnUser = false)
    {
        $token = $_COOKIE['token'] ?? false;
        if (!$token) {
            return false;
        } else {
            $foundUsers = DB::selectWhere($returnUser ? '*' : 'rememberMeToken, id', 'users', 'rememberMeToken', $token);
            if (count($foundUsers) == 1) {
                // Update last login
                $user = $foundUsers[0];
                if ($user && !$returnUser) {
                    return true;
                } else {
                    return $user;
                }
            } else {
                return false;
            }
        }
    }

    public function generateHash(string $string)
    {
        // password_default = bcrypt but can change in newer versions, in case it does hashes are re-generated
        return password_hash($string, PASSWORD_DEFAULT, CAuthentication::HASHING_OPTIONS);
    }

    private function verifyHash(string $hash, string $password)
    {
        return password_verify($password, $hash);
    }

    private function verifyCredentials(string $email, string $password)
    {
        $users = DB::selectAll('users');
        foreach ($users as $user) {
            // if matches, user has filled in correct password
            if ($this->verifyHash($user['password'], $password) && $email == $user['email']) {
                if (password_needs_rehash($user['password'], PASSWORD_BCRYPT, CAuthentication::HASHING_OPTIONS)) {
                    // since the password is verified to be the correct one we can use the user input here to hash
                    $hash = $this->generateHash($password);
                    DB::updateEntry(2, 'users', [
                        'password' => "{$hash}",
                    ]);
                }
                return array_merge($user, [
                    'rememberMeToken' => $user['rememberMeToken'],
                    'isValid' => true,
                ]);
            }
        }
        return [
            'rememberMeToken' => null,
            'isValid' => false,
        ];
    }
}