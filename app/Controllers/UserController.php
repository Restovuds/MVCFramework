<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;
use Ocore\helpers\FlashHelper;
use Ocore\security\Security;

class UserController extends BaseController
{
    public function actionRegister(): string
    {
        if (request()->isPost()) {
            $user = new User();
            $user->scenario = User::SCENARIO_REGISTER;
            $user->load(request()->post());

            if (!$user->validate()) {
                return view(view: 'user/register', data: ['title' => 'Sing up', 'errors' => $user->getErrorsAsArray()]);
            }

            if ($user->save(false)) {
                FlashHelper::createSuccessAlert("You have successfully registered.");
                response()->redirect(LOGIN_PAGE);
            } else {
                FlashHelper::createErrorAlert("Registration failed due to unknown reasons. Try again later.");
                response()->redirect("/");
            }
        }

        return view(view: 'user/register', data: ['title' => 'Register Form']);
    }

    public function actionLogin(): string
    {
        if (request()->isPost()) {
            $user = new User();
            $user->setScenario(User::SCENARIO_LOGIN);
            $user->load(request()->post());

            if (!$user->validate()) {
                return view(view: 'user/login', data: ['title' => 'Login Form', 'errors' => $user->getErrorsAsArray()]);
            }

            if (!$user->authenticate()) {
                FlashHelper::createErrorAlert("Invalid email or password");
                return view(view: 'user/login', data: ['title' => 'Login Form', 'errors' => $user->getErrorsAsArray()]);
            }

            FlashHelper::createSuccessAlert("You have successfully logged in.");
            response()->redirect("/");
        }
        return view(view: 'user/login', data: ['title' => 'Login Form']);
    }

    public function actionLogout(): string
    {
        if (check_auth()) {
            session()->remove('user');
        }
        response()->redirect("/");
    }

}