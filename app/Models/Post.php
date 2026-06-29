<?php

namespace App\Models;

use helpers\MimeTypes;
use helpers\UploadedFile;
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
//            [['thumbnail'], ValidatorFactory::VALIDATOR_REQUIRED],
//            [
//                ['gallery'],
//                ValidatorFactory::VALIDATOR_FILE,
//                'extensions' => [
//                    MimeTypes::MIME_IMAGE_JPEG,
//                    MimeTypes::MIME_IMAGE_JPG,
//                    MimeTypes::MIME_IMAGE_PNG,
//                ],
//                'maxSize'         => 2 * 1024 * 1024,
//                'maxFiles'        => 2,
//                'errorOnEachFile' => true,
//            ]
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

    public function getThumbnail(): array
    {
        return db()->query("SELECT path, name FROM ? WHERE id = ?", [Gallery::tableName(), $this->attributes['id']])->asArray();
    }

    public function savePost(): false|string
    {
        $thumbnail = null;
        if (isset($this->attributes['thumbnail'])) {
            $thumbnail = $this->attributes['thumbnail'];
        }
        unset($this->attributes['thumbnail']);

        $gallery = null;
        if (isset($this->attributes['gallery'])) {
            $gallery = $this->attributes['gallery'];
            unset($this->attributes['gallery']);
        }

        $id = $this->save(false);

        if ($thumbnail) {
            if ($path = UploadedFile::uploadFile($thumbnail[0])) {
                db()->query("UPDATE post SET thumbnail = ? WHERE id = ?", [$path, $id]);
            }
        }
        if ($gallery) {
            $galleryItems = [];
            foreach ($gallery as $item) {
                if ($path = UploadedFile::uploadFile($item)) {
                    $galleryItems[] = [
                        'post_id' => $id,
                        'path' => $path,
                        'name' => $item->name,
                    ];
                }
            }
            if (!empty($galleryItems)) {
                foreach ($galleryItems as $item) {
                    $galleryModel = new Gallery();
                    $galleryModel->load($item);
                    dump($item);
                    dump($galleryModel);
                    $galleryModel->save();
                }
            }
        }

        return $id;
    }
}
