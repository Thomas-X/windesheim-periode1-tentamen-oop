<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/11/18
 * Time: 11:51
 */

namespace Qui\app\http\controllers;


use Qui\lib\App;
use Qui\lib\facades\Authentication;
use Qui\lib\facades\DB;
use Qui\lib\facades\View;
use Qui\lib\Request;
use Qui\lib\Response;
use Qui\lib\Routes;

class ForumController
{
    public function showForumHome(Request $req, Response $res)
    {
        $posts = DB::execute("SELECT users.fname, users.lname, posts.id, posts.name, posts.lastTimeStamp FROM posts INNER JOIN `users` ON users.`id` = posts.`creatorid` ORDER BY posts.lastTimeStamp DESC");
        return View::react(App::REACT_APP_COMPONENTS['forum-home'], [
            'routes' => Routes::$routes,
            'posts' => $posts
        ], 'Forum home');
    }

    public function showPostCreate(Request $req, Response $res)
    {
        return View::render('pages.CreatePost');
    }

    public function showPostUpdate(Request $req, Response $res)
    {
        $post = (DB::selectWhere('*', 'posts', 'id', $req->params['id']))[0];
        return View::render('pages.UpdatePost', compact('post'));
    }

    public function onPostCreate(Request $req, Response $res)
    {
        $user = Authentication::verify(true);
        DB::insertEntry('posts', [
            'creatorid' => $user['id'],
            'lastTimeStamp' => date('Y-m-d'),
            'name' => $req->params['name'],
            'description' => $req->params['description']
        ]);
        return $res->redirect(Routes::$routes['forum-home']);
    }

    public function onPostUpdate(Request $req, Response $res)
    {
        $user = Authentication::verify(true);
        $post = (DB::selectWhere('*', 'posts', 'id', $req->params['id']))[0];
        if ($post['creatorid'] != $user['id']) {
            return $res->redirect(Routes::$routes['forum-home'], 401);
        }
        DB::updateEntry($req->params['id'], 'posts', [
            'creatorid' => $user['id'],
            'lastTimeStamp' => date('Y-m-d'),
            'name' => $req->params['name'],
            'description' => $req->params['description'],
        ],
            'id');
        return $res->redirect(Routes::$routes['forum-home']);
    }

    public function onPostRemove(Request $req, Response $res)
    {
        if (!$req->params['id']) {
            $res->redirect(Routes::$routes['forum-home'], 401);
        }
        $user = Authentication::verify(true);
        $post = (DB::selectWhere('*', 'posts', 'id', $req->params['id']))[0];
        if ($post['creatorid'] != $user['id']) {
            return $res->redirect(Routes::$routes['forum-home'], 401);
        }

        DB::deleteEntry('posts', 'id', $req->params['id']);
        return $res->redirect(Routes::$routes['forum-home']);
    }

    public function showPostRead(Request $req, Response $res) {
        $comments = DB::execute("SELECT comments.creatorid, comments.votes, comments.comment, comments.lastTimeStamp, comments.id, users.fname, users.lname FROM comments INNER JOIN `users` ON users.`id` = comments.`creatorid`WHERE comments.`postid` = ? ORDER BY comments.votes DESC", [$req->params['id']]);
        $post = (DB::selectWhere('*', 'posts', 'id', $req->params['id']))[0];
        return View::render('pages.ReadPost', compact('comments', 'post'));
    }

    public function onVote(Request $req, Response $res) {

        $vote = 0;
        if ($req->params['vote'] == "-1") {
            $vote = -1;
        } else if ($req->params['vote'] == "1") {
            $vote = 1;
        }
        $comment = (DB::selectWhere('*', 'comments', 'id', $req->params['commentId']))[0];
        $post = (DB::selectWhere('*', 'posts', 'id', $req->params['postId']))[0];

        $user = Authentication::verify(true);
        if ($comment['creatorid'] != $user['id']) {
            return $res->redirect(Routes::$routes['forum-home'], 401);
        }

        DB::updateEntry($comment['id'], 'comments', [
            'votes' => $comment['votes'] + $vote
        ], 'id');
        return $res->redirect(Routes::$routes['forum-post-read'] . '?id=' . $post['id']);
    }

    public function onCommentCreate (Request $req, Response $res) {
        $user = Authentication::verify(true);
        DB::insertEntry('comments', [
            'lastTimeStamp' => date('Y-m-d'),
            'comment' => $req->params['comment'],
            'postid' => $req->params['postId'],
            'creatorid' => $user['id'],
            'votes' => 0
        ]);
        return $res->redirect(Routes::$routes['forum-post-read'] . '?id=' . $req->params['postId']);
    }

    public function onCommentUpdate (Request $req, Response $res) {
        $comment = (DB::selectWhere('*', 'comments', 'id', $req->params['commentId']))[0];

        $user = Authentication::verify(true);
        if ($comment['creatorid'] != $user['id']) {
            return $res->redirect(Routes::$routes['forum-home'], 401);
        }

        DB::updateEntry($req->params['commentId'], 'comments', [
            'comment' => $req->params['comment'],
        ]);
        return $res->redirect(Routes::$routes['forum-post-read'] . '?id=' . $comment['postid']);
    }

    public function showCommentUpdate(Request $req, Response $res) {
        $comment = (DB::selectWhere('*', 'comments', 'id', $req->params['id']))[0];

        $user = Authentication::verify(true);
        if ($comment['creatorid'] != $user['id']) {
            return $res->redirect(Routes::$routes['forum-home'], 401);
        }

        return View::render('pages.CommentUpdate', compact('comment'));
    }

    public function onCommentDelete(Request $req, Response $res) {
        $comment = (DB::selectWhere('*', 'comments', 'id', $req->params['id']))[0];

        $user = Authentication::verify(true);
        if ($comment['creatorid'] != $user['id']) {
            return $res->redirect(Routes::$routes['forum-home'], 401);
        }

        $commentPostId = $comment['postid'];

        DB::deleteEntry('comments', 'id', $req->params['id']);
        return $res->redirect(Routes::$routes['forum-post-read'] . '?id=' . $commentPostId);
    }
}