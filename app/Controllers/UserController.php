<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;
use Ocore\helpers\FlashHelper;

class UserController extends BaseController
{
    public function actionRegister(): string
    {
        if (request()->isPost()) {
            $user = new User();
            $user->load(request()->post());

            if (!$user->validate()) {
                return view(view: 'user/register', data: ['title' => 'Sing up', 'errors' => $user->getErrorsAsArray()]);
            }

            if ($user->save(false)) {
                FlashHelper::createSuccessAlert("You have successfully registered.");
                response()->redirect("/login");
            } else {
                FlashHelper::createErrorAlert("Registration failed due to unknown reasons. Try again later.");
                response()->redirect("/");
            }
        }

        return view(view: 'user/register', data: ['title' => 'Register Form']);
    }

}