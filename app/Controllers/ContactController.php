<?php

namespace App\Controllers;

use App\Models\Contact;
use Ocore\helpers\FlashHelper;
use helpers\UploadedFile;

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

        if (!$model->validate()) {
            return view('contact/index', ['title' => self::DEFAULT_TITLE, 'errors' => $model->getErrorsAsArray()]);
        }

        if (!$model->sendContactEmail()) {
            FlashHelper::createErrorAlert('Failed to send your message. Please try again later.');
            return view('contact/index', ['title' => self::DEFAULT_TITLE, 'errors' => $model->getErrorsAsArray()]);
        }

        FlashHelper::createSuccessAlert('Your message has been sent successfully!');
        response()->redirect('/');
    }
}
