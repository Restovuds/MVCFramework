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

    public function edit(): string
    {
        $id = request()->get('id');
        $post = db()->findOrFail(Post::tableName(), $id);
        return $this->render(view: 'posts/edit', data: ['title' => 'Edit Post', 'post' => $post]);
    }

    public function update()
    {
        $id = request()->post('id');
        $post = db()->findOrFail(Post::tableName(), $id);
        if (!$post) {
            FlashHelper::createErrorAlert("Post not found");
            response()->redirect('/');
        }

        $model = new Post();
        $model->load();
        $model->attributes['id'] = $id;

        if (!$model->validate()) {
            FlashHelper::createErrorAlert($model->getErrorsAsHtml());
            response()->redirect("/posts/edit?id={$id}");
        }

        if ($model->update()) {
            FlashHelper::createSuccessAlert("Post {$id} saved");
            response()->redirect('/' );
        } else {
            FlashHelper::createErrorAlert("Error updating the {$id} post");
            response()->redirect("/posts/edit?id={$id}");
        }
    }

}