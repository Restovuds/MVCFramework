<?php

namespace App\Controllers;

use App\Models\Post;
use helpers\UploadedFile;
use Ocore\helpers\FlashHelper;

class PostController extends BaseController
{
    public function actionCreate(): string
    {
        return $this->render(view: 'posts/create', data: ['title' => 'Create Post']);
    }

    public function actionStore(): string
    {
        $model = new Post();
        $model->load();

        $model->attributes['thumbnail'] = isset($_FILES['thumbnail'])
            ? UploadedFile::createFromFiles($_FILES['thumbnail'])
            : [];

        if (!$model->validate()) {
            return $this->render(view: 'posts/create', data: ['title' => 'Create Post', 'errors' => $model->getErrorsAsArray()]);
        }

        if ($id = $model->savePost()) {
            FlashHelper::createSuccessAlert("Post {$id} created");
        } else {
            FlashHelper::createErrorAlert("Create post failed");
        }

        response()->redirect('/posts/create');
    }

    public function actionEdit(): string
    {
        $id = request()->get('id');
        $post = db()->findOrFail(Post::tableName(), $id);
        return $this->render(view: 'posts/edit', data: ['title' => 'Edit Post', 'post' => $post]);
    }

    public function actionUpdate(): void
    {
        $id = request()->post('id');
        db()->findOrFail(Post::tableName(), $id);

        $model = new Post();
        $model->load();
        $model->attributes['id'] = $id;

        if (!$model->validate()) {
            FlashHelper::createErrorAlert($model->getErrorsAsHtml());
            response()->redirect("/posts/edit?id={$id}");
        }

        if ($model->update()) {
            FlashHelper::createSuccessAlert("Post {$id} saved");
            response()->redirect("/");
        } else {
            FlashHelper::createErrorAlert("Error updating the {$id} post");
            response()->redirect("/posts/edit?id={$id}");
        }
    }

    public function actionDelete(): void
    {
        $id = request()->get('id');
        db()->findOrFail(Post::tableName(), $id);
        $model = new Post();

        if(!$model->delete($id)) {
            FlashHelper::createErrorAlert("Error deleting the {$id} post");
        } else {
            FlashHelper::createSuccessAlert("Post {$id} deleted");
        }

        response()->redirect("/");
    }

    public function actionView(): string
    {
        $slug = router()->getRootParam('slug', false);
        if (!$slug) {
            abort();
        }

        if (!$post = db()->find(Post::tableName(), ['slug' => $slug])->one()) {
            abort();
        }

        return $this->render(view: 'posts/view', data: ['title' => $post['title'], 'post' => $post]);
    }
}
