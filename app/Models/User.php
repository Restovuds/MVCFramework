<?php

namespace App\Models;

use helpers\MimeTypes;
use helpers\UploadedFile;
use Ocore\BaseModel;
use Ocore\validation\ValidatorFactory;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $password_repeat
 */
class User extends BaseModel
{
    public static function tableName(): string
    {
        return 'user';
    }

    public function getRules(): array
    {
        return [
            [['first_name', 'email', 'password', 'password_repeat'], ValidatorFactory::VALIDATOR_REQUIRED],
            [['email'], ValidatorFactory::VALIDATOR_EMAIL],
            [['email'], ValidatorFactory::VALIDATOR_UNIQUE, 'message' => 'This email address has already been taken.'],
            [['email'], ValidatorFactory::VALIDATOR_STRING, 'min' => 5, 'max' => 100],
            [['first_name', 'last_name'], ValidatorFactory::VALIDATOR_STRING, 'min' => 2, 'max' => 50],
            [['password', 'password_repeat'], ValidatorFactory::VALIDATOR_STRING, 'min' => 6, 'max' => 255],
            [['password_repeat'], 'validatePasswordRepeat', 'message' => 'Passwords do not match'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email Address',
            'password' => 'Password',
            'password_repeat' => 'Repeat Password',
        ];
    }

    public function validatePasswordRepeat($attribute, $config): bool
    {
        $p = $this->password;
        $rp = $this->password_repeat;

        $rp = trim($rp);
        if ($p !== $rp) {
            return false;
        }

        return true;
    }

    public function save($runValidation = true): false|string
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        unset($this->password_repeat);
        return parent::save($runValidation);
    }
}
