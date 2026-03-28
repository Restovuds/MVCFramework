<?php

namespace App\Controllers;

use App\Models\Contact;
use Ocore\BaseController;

class ContactController extends BaseController
{
    private const string DEFAULT_TITLE = 'Contact Page';


    public function index()
    {
        $title = 'Contact Page';
        return view('contact', ['title' => self::DEFAULT_TITLE]);
    }

    public function send()
    {
        $model = new Contact();
        $model->load();

        if ($model->validate()) {
            return view('contact', ['title' => self::DEFAULT_TITLE, 'errors' => $model->getErrorsAsArray()]);
        }

        response()->redirect('/');
    }
}