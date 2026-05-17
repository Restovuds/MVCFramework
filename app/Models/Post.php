<?php

namespace App\Models;

use Ocore\helpers\TextHelper;

class Post extends \Ocore\BaseModel
{
    public array $fillable = ['title', 'content'];

    public static function tableName(): string
    {
        return 'post';
    }

    public function getRules(): array
    {
        return [
            [['title', 'content'], 'required'],
            [['title'], 'string', 'min' => 5, 'max' => 255],
            [['title'], 'unique', 'message' => 'This title has already been taken.'],
            [['content'], 'string', 'min' => 20, 'max' => 1000],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'title' => 'Post Title',
            'slug' => 'Slug',
            'content' => 'Post Comment'
        ];
    }

    public function save($runValidation = true): false|string
    {
        if ($this->validate()) {
            $this->attributes['slug'] = TextHelper::createSlug($this->attributes['title']);
            return parent::save($runValidation);
        }
        return false;
    }
}
