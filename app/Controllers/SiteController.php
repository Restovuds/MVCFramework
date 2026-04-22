<?php

namespace App\Controllers;

class SiteController extends BaseController
{
    public function index()
    {
//        $posts = db()->query('SELECT * FROM post where id > ?', [1])->asArray();
//        $posts = db()->findAll('post');
//        $posts = db()->findOne('post', 2);
//        $posts = db()->findOrFail('post', 3, 'Post not found', 'Please try again later');
//        dd($posts);
        return view('site/index', ['title' => 'Home Page']);
    }
}