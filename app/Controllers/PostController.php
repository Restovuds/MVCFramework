<?php

namespace App\Controllers;

use App\Models\Post;
use Ocore\helpers\FlashHelper;

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

        if (!$model->validate()) {
            return $this->render(view: 'posts/create', data: ['title' => 'Create Post', 'errors' => $model->getErrorsAsArray()]);
        }

        if ($id = $model->save()) {
            FlashHelper::createSuccessAlert("Post {$id} created");
        } else {
            FlashHelper::createErrorAlert("Create post failed");
        }
        response()->redirect('/posts/create');
    }

}