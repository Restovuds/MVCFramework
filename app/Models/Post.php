<?php

namespace App\Models;

use helpers\MimeTypes;
use helpers\UploadedFile;
use Ocore\BaseModel;
use Ocore\validation\ValidatorFactory;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string $thumbnail
 * @property array $gallery
 */
class Post extends BaseModel
{
    public const string SCENARIO_EDIT = 'edit';

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
            ],
            [
                ['gallery'],
                ValidatorFactory::VALIDATOR_FILE,
                'extensions' => [
                    MimeTypes::MIME_IMAGE_JPEG,
                    MimeTypes::MIME_IMAGE_JPG,
                    MimeTypes::MIME_IMAGE_PNG,
                ],
                'maxSize'         => 2 * 1024 * 1024,
                'maxFiles'        => 2,
                'errorOnEachFile' => true,
            ]
        ];
    }

    public function scenarios(): array
    {
        return [
            self::SCENARIO_DEFAULT => ['title', 'slug', 'content', 'thumbnail', 'gallery'],
            self::SCENARIO_EDIT => ['title', 'content'],
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
        $tableName = Gallery::tableName();
        return db()->query("SELECT path, name FROM $tableName WHERE id = ?", [$this->attributes['id']])->asArray();
    }

    public function savePost(): false|string
    {
        $thumbnail = null;
        if (isset($this->attributes['thumbnail'])) {
            $thumbnail = $this->thumbnail;
        }
        unset($this->thumbnail);

        $gallery = null;
        if (isset($this->attributes['gallery'])) {
            $gallery = $this->gallery;
        }
        unset($this->gallery);

        $id = $this->save(false);

        /** @var UploadedFile[] $thumbnail */
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
                    $galleryModel->save();
                }
            }
        }

        return $id;
    }
}
