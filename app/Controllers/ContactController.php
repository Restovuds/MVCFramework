<?php

namespace App\Controllers;

use App\Models\Contact;

class ContactController extends BaseController
{
    private const string DEFAULT_TITLE = 'Contact Page';


    public function actionIndex()
    {
        return view('contact/index', ['title' => self::DEFAULT_TITLE]);
    }

    public function actionSend()
    {
        $model = new Contact();
        $model->load();

        if ($model->validate()) {
            return view('contact', ['title' => self::DEFAULT_TITLE, 'errors' => $model->getErrorsAsArray()]);
        }

        response()->redirect('/');
    }
}