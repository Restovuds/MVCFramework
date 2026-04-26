<?php

namespace App\Models;

use Ocore\Validators;

class Post extends \Ocore\BaseModel
{
    public array $fillable = ['title', 'content'];
    public array $attributeLabels = ['title' => 'Post Title', 'content' => 'Post Comment'];

    public array $rules = [
        'title' => [Validators::REQUIRED, Validators::MIN => 5, Validators::MAX => 255],
        'content' => [Validators::REQUIRED, Validators::MIN => 20, Validators::MAX => 1000],
    ];

    public static function tableName(): string
    {
        return 'post';
    }

}