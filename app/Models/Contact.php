<?php

namespace App\Models;

use Ocore\BaseModel;
use Ocore\validation\ValidatorFactory;

class Contact extends BaseModel
{
    public array $fillable = ['fullName', 'email', 'content', 'username'];

    public static function tableName(): string
    {
        return 'contact';
    }

    public function getRules(): array
    {
        return [
            [['fullName', 'email'], ValidatorFactory::VALIDATOR_REQUIRED],
            [['email'], ValidatorFactory::VALIDATOR_EMAIL],
            [['content'], ValidatorFactory::VALIDATOR_STRING, 'min' => 20, 'max' => 225],
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
            'username' => 'Username'
        ];
    }
}
