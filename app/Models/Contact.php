<?php

namespace App\Models;


use Ocore\Validators;

class Contact extends \Ocore\BaseModel
{
    public array $fillable = ['fullName', 'email', 'content', 'username'];

    public array $rules = [
        'fullName' => [Validators::REQUIRED],
        'email' => [Validators::REQUIRED, Validators::EMAIL],
        'content' => [Validators::MIN => 20, Validators::MAX => 225],
    ];

}