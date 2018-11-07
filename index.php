<?php

// Used for (composer) autoloading
require __DIR__ . '/bootstrap.php';

use Qui\lib\App;
use Qui\lib\Database;
use Qui\lib\CView;
use Qui\lib\CRouter;
use Qui\lib\CUtil;
use Qui\lib\CAuthentication;
use Qui\lib\CValidator;
use Qui\lib\CMailer;
use Qui\lib\CNotifierParser;


$_URL_PREPEND = "/~s1130146/P1_OOAPP_Tentamen";

// if there should be a prefix to all routes.. i.e /somethingsomething/someapp/hereisroot/
\Qui\lib\Routes::morphRoutes($_URL_PREPEND);


// \Qui\lib\SuperSeriousErrorLogger::enableErrorLogging(false);

$_ENV = [];
// setup ENV variables before setting up database classes etc
App::setupENV();

$db = new Database();
$util = new CUtil();
$validator = new CValidator();
$view = new CView();
$router = new CRouter();
$auth = new CAuthentication();
$mailer = new CMailer();
$notifierParser = new CNotifierParser();

App::setupDependencies([
    'database'                  => $db, // eloquent was used here but now it's not anymore, because packages can't be used
    'pdo'                       => $db->pdo,
    'validator'                 => $validator,
    'view'                      => $view,
    'router'                    => $router,
    'util'                      => $util,
    'authentication'            => $auth,
    'mailer'                    => $mailer,
    'notifierparser'            => $notifierParser,
]);
App::setupRoutes(__DIR__ . '/routes/web.php');

// setup global functions. I got tired of importing Util:: every time so this is a simple wrapper around Util::dd
function dd($val=null, $_=null) {
    $args = func_get_args();
    App::get('util')->dd(...$args);
}

App::run();

