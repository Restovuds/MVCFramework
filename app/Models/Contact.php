<?php

namespace App\Models;

use Ocore\BaseModel;
use Ocore\validation\ValidatorFactory;
use helpers\MimeTypes;
use helpers\UploadedFile;

/** 
 * @property string $fullName
 * @property string $email
 * @property string $content
 * @property array $attachment
 */
class Contact extends BaseModel
{
    public static function tableName(): string
    {
        return '';
    }

    public function getRules(): array
    {
        return [
            [['fullName', 'email'], ValidatorFactory::VALIDATOR_REQUIRED],
            [['email'], ValidatorFactory::VALIDATOR_EMAIL],
            [['content'], ValidatorFactory::VALIDATOR_STRING, 'min' => 20, 'max' => 2250],
            [['attachment'], 
                ValidatorFactory::VALIDATOR_FILE, 
                'maxSize' => 5 * 1024 * 1024,
                'maxFiles' => 3,
                'extensions' => [
                    MimeTypes::MIME_IMAGE_JPEG,
                    MimeTypes::MIME_IMAGE_JPG,
                    MimeTypes::MIME_IMAGE_PNG,
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'fullName' => 'Full Name',
            'email' => 'Email',
            'content' => 'Comment',
            'attachment' => 'Attachments',
        ];
    }

    public function sendContactEmail(): bool
    {
        $content = nl2br(htmlspecialchars($this->content, ENT_QUOTES, 'UTF-8'));
        $body = "
            <b>Full Name:</b> {$this->fullName}<br>
            <b>Email:</b> {$this->email}<br>
            <b>Content:</b> <p>{$content}</p>";

        $mail = app()->getMailer()->addAddress(MAILER['from_email'], MAILER['from_name'])
            ->setSubject('Contact Form Submission')
            ->setBody($body);

        if (isset($_FILES['attachment'])) {
            $this->attachment = isset($_FILES['attachment'])
            ? UploadedFile::createFromFiles($_FILES['attachment'])
            : [];
            /** @var UploadedFile $file */
            $filePath = [];
            foreach ($this->attachment as $i => $file) {
                $filePath[$i] = UploadedFile::uploadFile($file, true);
                $mail->addAttachment($filePath[$i], $file->name);
            }
        }

        $isSent = $mail->send();

        foreach ($filePath ?? [] as $path) {
            if (file_exists($path)) {
                unlink($path);
            }
        }

        return $isSent;
    }
}
