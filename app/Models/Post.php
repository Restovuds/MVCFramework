<?php

namespace App\Models;

use helpers\MimeTypes;
use Ocore\BaseModel;
use Ocore\validation\ValidatorFactory;

class Post extends BaseModel
{
    public array $fillable = ['title', 'content', 'slug'];

    public static function tableName(): string
    {
        return 'post';
    }

    public function getRules(): array
    {
        return [
            [['title', 'content', 'slug'], ValidatorFactory::VALIDATOR_REQUIRED],
            [['title', 'slug'], ValidatorFactory::VALIDATOR_STRING, 'min' => 5, 'max' => 255],
            [['content'], ValidatorFactory::VALIDATOR_STRING, 'min' => 20, 'max' => 1000],
            [['slug'], ValidatorFactory::VALIDATOR_UNIQUE, 'message' => 'This slug has already been taken.'],
            [['slug'], ValidatorFactory::VALIDATOR_SLUG, 'message' => 'The slug pattern is :slugPattern:', 'messageConfig' => [':slugPattern:' => '/^[a-z0-9-]+$/']],
            [['thumbnail'], ValidatorFactory::VALIDATOR_REQUIRED],
            [
                ['thumbnail'],
                ValidatorFactory::VALIDATOR_FILE,
                'extensions' => [
                    MimeTypes::MIME_IMAGE_JPEG,
                    MimeTypes::MIME_IMAGE_JPG,
                    MimeTypes::MIME_IMAGE_PNG,
                ],
                'maxSize'         => 2 * 1024 * 1024,
                'maxFiles'        => 1,
                'errorOnEachFile' => true,
            ]
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'title' => 'Post Title',
            'slug' => 'Slug',
            'content' => 'Post Comment',
            'thumbnail' => 'Thumbnail',
        ];
    }
}
