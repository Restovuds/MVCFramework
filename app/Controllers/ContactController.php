<?php

namespace App\Controllers;

use App\Models\Contact;
use Ocore\BaseController;

class ContactController extends BaseController
{
    public function index()
    {
        $title = 'Contact Page';

        return view('contact', compact('title'));
    }

    public function send()
    {
        $model = new Contact();
        $model->load();
        dump($model);
        $model->validate();
        dump($model);
        echo 'Contact Form POST Page';
    }
}