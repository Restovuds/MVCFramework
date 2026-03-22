<?php

namespace App\Controllers;

use App\Models\Contact;
use Ocore\BaseController;

class ContactController extends BaseController
{
    public function index()
    {
        $title = 'Contact Page';
        $name = 'Oleh';

        return view('contact', compact('title', 'name'));
    }

    public function send()
    {
        $model = new Contact();
        dump($model);
        $model->load();
        dump($model);
        echo 'Contact Form POST Page';
    }
}