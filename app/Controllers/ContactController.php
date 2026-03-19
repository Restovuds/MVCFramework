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
//        return view()->render('contact');
//        return $this->render('contact.php');
//        return app()->view->render('contact');
    }

    public function send()
    {
        echo 'Contact Form POST Page';
    }
}