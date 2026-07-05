<?php

namespace App\Controllers;

use App\Models\Post;
use Ocore\Pagination;
use Ocore\View;

class SiteController extends BaseController
{
    public function actionIndex(): View|string
    {
        $page = (int)request()->get('page', 1);
        $total = db()->count(Post::tableName());
        $limit = (int)request()->get('limit', 5);

        $pagination = new Pagination(page: $page, limit: $limit, total: $total);
        $start = $pagination->getStart();

        $tableName = Post::tableName();
        $posts = db()->query("SELECT * FROM {$tableName} ORDER BY id DESC LIMIT {$start}, {$limit}")->asArray();

        return view('site/index', ['title' => 'Home Page', 'posts' => $posts, 'pagination' => $pagination]);
    }
}
