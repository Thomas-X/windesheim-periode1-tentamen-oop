<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/11/18
 * Time: 09:47
 */

namespace Qui\app\http\controllers;


use Qui\lib\facades\DB;
use Qui\lib\facades\View;
use Qui\lib\Request;
use Qui\lib\Response;
use Qui\lib\Routes;

/*
 * The controller used for all of the blends part of the site.
 * The method names speak for themselves.
 * */
class BlendsController
{
    public static $params = [
        'name',
        'description',
        'step01',
        'ingredient01',
        'step02',
        'ingredient02',
        'step03',
        'ingredient03',
        'step04',
        'ingredient04',
        'step05',
        'ingredient05',
        'step06',
        'ingredient06',
        'timeToPrep',
    ];

    public function showBlends(Request $req, Response $res)
    {
        $blends = DB::execute("SELECT * FROM recipees WHERE isApproved=1");
        $blendsRecentlyApproved = DB::execute("SELECT * FROM recipees WHERE isApproved=1 ORDER BY lastUpdate DESC LIMIT 200");
        $blendsAwaitingApproval = DB::execute("SELECT * FROM recipees WHERE isApproved=0 ORDER BY lastUpdate DESC LIMIT 200");
        return View::render('pages.Blends', compact('blends', 'blendsRecentlyApproved', 'blendsAwaitingApproval'));
    }

    public function showAddBlend(Request $req, Response $res)
    {
        return View::render('pages.AddBlend');
    }

    public function showUpdateBlend(Request $req, Response $res)
    {
        $blend = (DB::selectWhere('*', 'recipees', 'id', $req->params['id']))[0];
        return View::render('pages.UpdateBlend', compact('blend'));
    }

    public function onAddBlend(Request $req, Response $res)
    {
        $values = [];
        foreach (BlendsController::$params as $param) {
            $values[$param] = $req->params[$param];
        }
        $values['lastUpdate'] = date('Y-m-d');
        DB::insertEntry('recipees', $values);
        return $res->redirect(Routes::$routes['blends']);
    }

    public function onUpdateBlend(Request $req, Response $res)
    {
        $values = [];
        foreach (BlendsController::$params as $param) {
            $values[$param] = $req->params[$param];
        }
        $values['lastUpdate'] = date('Y-m-d');
        DB::updateEntry($req->params['id'], 'recipees', $values,
            'id');
        return $res->redirect(Routes::$routes['blends']);
    }

    public function onRemoveBlend(Request $req, Response $res) {
        if (!$req->params['id']) {
            $res->redirect(Routes::$routes['blends'], 401);
        }
        DB::deleteEntry('recipees', 'id', $req->params['id']);
        return $res->redirect(Routes::$routes['blends']);
    }

    public function onApproveBlend(Request $req, Response $res) {
        DB::updateEntry($req->params['id'], 'recipees', [
            'isApproved' => 1
        ], 'id');
        return $res->redirect(Routes::$routes['blends']);
    }
}