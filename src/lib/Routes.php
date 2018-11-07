<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 09/10/18
 * Time: 20:03
 */

namespace Qui\lib;


class Routes
{
    static public $routePrefix = "";
    static public $routes = [
        'home' => '/',
        'login' => '/login',
        'logout' => '/logout',
        'register' => '/register',
        'onRegister' => '/register',
        'blends' => '/blends',
        'addBlend' => '/add_blend',
        'updateBlend' => '/update_blend',
        'removeBlend' => '/remove_blend',
        'approveBlend' => '/approve_blend',

        // forum
        'forum-home' => '/forum',

        // post
        'forum-post-create' => '/forum/post/create',
        'forum-post-update' => '/forum/post/update',
        'forum-post-delete' => '/forum/post/delete',

        // ?id=1
        'forum-post-read' => '/forum/post',

        // comment
        'forum-comment-create' => '/forum/comment/create',
        'forum-comment-update' => '/forum/comment/update',
        'forum-comment-delete' => '/forum/comment/delete',

        // upvote / downvote
        // in request i.e: vote: -1 or 1
        // -1 = downvote
        // 1 = upvote
        'forum-comment-vote' => '/forum/comment/vote',
    ];

    public static function morphRoutes($path)
    {
        Routes::$routePrefix = $path;
        foreach (Routes::$routes as $key => $route) {
            Routes::$routes[$key] = $path . Routes::$routes[$key];
        }
    }
}