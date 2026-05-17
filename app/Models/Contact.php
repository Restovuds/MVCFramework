<?php

namespace App\Models;

class Contact extends \Ocore\BaseModel
{
    public array $fillable = ['fullName', 'email', 'content', 'username'];

    public static function tableName(): string
    {
        return 'contact';
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

    public function getRules(): array
    {
        return [
            [['fullName', 'email'], 'required'],
            [['email'], 'email'],
            [['content'], 'string', 'min' => 20, 'max' => 225],
        ];
    }
}
