<?php

use Qui\lib\App;
use Qui\lib\facades\Router;
use Qui\lib\Routes;
use Qui\lib\Request;
use Qui\lib\Response;

/*
 *
 * No middleware routes should be placed before middleware routes (is nice)
 *
 * */

/*
 * GET
 * */
Router::get(Routes::$routes['home'], 'HomeController@showHome');

/*
 * POST
 * */
// unprotected always available post routes go here, otherwise use middelware

/*
 *
 * MIDDLEWARE
 *
 * */

/*
 * Forgot password token verification middleware
 * */
//Router::middleware(['AuthenticationMiddleware@resetPassword'], [
//    [
//        App::GET,
//        Routes::$routes['resetPassword'],
//        'AuthenticationController@showResetPassword'
//    ],
//    [
//        App::POST,
//        Routes::$routes['resetPassword'],
//        'AuthenticationController@onResetPassword'
//    ]
//]);

/*
 * Should be logged in middleware
 * */
Router::middleware(['AuthenticationMiddleware@shouldBeLoggedIn'], [
    [
        App::GET,
        Routes::$routes['logout'],
        'AuthenticationController@onLogout'
    ],
    [
        App::GET,
        Routes::$routes['blends'],
        'BlendsController@showBlends'
    ],
    [
        App::GET,
        Routes::$routes['addBlend'],
        'BlendsController@showAddBlend'
    ],
    [
        App::GET,
        Routes::$routes['forum-home'],
        'ForumController@showForumHome'
    ],
    [
        App::POST,
        Routes::$routes['addBlend'],
        'BlendsController@onAddBlend'
    ],
    [
        App::GET,
        Routes::$routes['forum-post-create'],
        'ForumController@showPostCreate'
    ],
    [
        App::POST,
        Routes::$routes['forum-post-create'],
        'ForumController@onPostCreate'
    ],
    [
        App::GET,
        Routes::$routes['forum-post-read'],
        'ForumController@showPostRead'
    ],
    [
        App::POST,
        Routes::$routes['forum-comment-vote'],
        'ForumController@onVote'
    ],
    [
        App::POST,
        Routes::$routes['forum-comment-create'],
        'ForumController@onCommentCreate',
    ],
    [
        App::GET,
        Routes::$routes['forum-comment-update'],
        'ForumController@showCommentUpdate'
    ],
    [
        App::POST,
        Routes::$routes['forum-comment-update'],
        'ForumController@onCommentUpdate'
    ],
    [
        App::POST,
        Routes::$routes['forum-comment-delete'],
        'ForumController@onCommentDelete'
    ]
]);

/*
 * Should be 'meest Barista'
 * */
Router::middleware(['MeesterBaristaMiddleware@next'], [
    [
        App::GET,
        Routes::$routes['updateBlend'],
        'BlendsController@showUpdateBlend',
    ],
    [
        App::POST,
        Routes::$routes['updateBlend'],
        'BlendsController@onUpdateBlend'
    ],
    [
        App::POST,
        Routes::$routes['approveBlend'],
        'BlendsController@onApproveBlend'
    ],
    [
        App::POST,
        Routes::$routes['removeBlend'],
        'BlendsController@onRemoveBlend'
    ],

]);

/*
 * Should not be logged in middleware
 * */
Router::middleware(['AuthenticationMiddleware@shouldNotBeLoggedIn'], [
    [
        App::GET,
        Routes::$routes['login'],
        'AuthenticationController@showLogin'
    ],
    [
        App::GET,
        Routes::$routes['register'],
        'AuthenticationController@showRegister'
    ],
    [
        App::POST,
        Routes::$routes['login'],
        'AuthenticationController@onLogin'
    ],
    [
        App::POST,
        Routes::$routes['onRegister'],
        'AuthenticationController@onRegister'
    ],
]);
