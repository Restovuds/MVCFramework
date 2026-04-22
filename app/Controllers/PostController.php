<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Post;

class PostController extends BaseController
{
    public function create(): string
    {
        return $this->render(view: 'posts/create', data: ['title' => 'Create Post']);
    }

    public function store(): string
    {
        $model = new Post();
        $model->load();

        if (!$model->save()) {
            return $this->render(view: 'posts/create', data: ['title' => 'Create Post', 'errors' => $model->getErrorsAsArray()]);
        }

        return "POST CREATED";
    }

}