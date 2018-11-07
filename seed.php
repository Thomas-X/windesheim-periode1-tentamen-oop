<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/10/18
 * Time: 13:10
 */
// DRY copy paste
require 'vendor/autoload.php';

use Qui\lib\Seeder;
use Qui\lib\App;
use Qui\lib\Database;
use Qui\lib\CView;
use Qui\lib\CRouter;
use Qui\lib\CUtil;
use Qui\lib\CAuthentication;
use Qui\lib\CValidator;
use Qui\lib\CMailer;
use Qui\lib\CNotifierParser;

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
    'database' => $db,
    // eloquent was used here but now it's not anymore, because packages can't be used
    'pdo' => $db->pdo,
    'validator' => $validator,
    'view' => $view,
    'router' => $router,
    'util' => $util,
    'authentication' => $auth,
    'mailer' => $mailer,
    'notifierparser' => $notifierParser,
]);
$val = Seeder::seed(true);
echo PHP_EOL . $val . PHP_EOL;
die;