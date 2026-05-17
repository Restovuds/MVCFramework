<?php

namespace App\Controllers;

class SiteController extends BaseController
{
    public function index()
    {
        $posts = db()->findAll('post');
        return view('site/index', ['title' => 'Home Page', 'posts' => $posts]);
    }
}
