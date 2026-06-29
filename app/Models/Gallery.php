<?php

namespace App\Models;

use Ocore\BaseModel;

class Gallery extends BaseModel
{
    public array $fillable = ['post_id', 'path', 'name'];
    /**
     * @inheritDoc
     */
    public static function tableName(): string
    {
        return 'gallery';
    }

    public function getRules(): array
    {
        return [
            [['post_id', 'path'], 'required'],
            [['path', 'name'], 'string', 'max' => 255],
            [['post_id'], 'integer'],
            [['post_id'], 'exist', 'targetClass' => Post::class, 'targetAttribute' => 'id'],
        ];
    }
}