<?php

namespace App\Controllers;

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
        dump(request()->getData());
        dump($_POST);
        echo 'Contact Form POST Page';
    }
}