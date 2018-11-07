<?php

namespace Qui\app\http\controllers;

use Qui\lib\App;
use Qui\lib\facades\DB;
use Qui\lib\facades\Mailer;
use Qui\lib\facades\NotifierParser;
use Qui\lib\facades\Util;
use Qui\lib\facades\Validator;
use Qui\lib\facades\View;
use Qui\lib\CMailer;
use Qui\lib\Request;
use Qui\lib\Response;
use Qui\lib\facades\Authentication;

/*
 * Show home page
 * */
class HomeController
{

    /**
     * @param Request $req
     * @param Response $res
     * @return mixed
     */
    public function showHome(Request $req, Response $res, $data)
    {
        return View::render('pages.Home');
    }
}