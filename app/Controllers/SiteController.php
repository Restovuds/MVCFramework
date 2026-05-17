<?php

namespace App\Controllers;

use Ocore\View;

class SiteController extends BaseController
{
    public function actionIndex(): View|string
    {
        $posts = db()->findAll('post');
        return view('site/index', ['title' => 'Home Page', 'posts' => $posts]);
    }
}
