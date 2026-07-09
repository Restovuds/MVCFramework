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
    const string SCENARIO_REGISTER = 'register';
    const string SCENARIO_LOGIN = 'login';

    public static function tableName(): string
    {
        return 'user';
    }

    public function scenarios(): array
    {
        return [
            self::SCENARIO_DEFAULT => ['first_name', 'last_name', 'email', 'password', 'password_repeat'],
            self::SCENARIO_REGISTER => ['first_name', 'last_name', 'email', 'password', 'password_repeat'],
            self::SCENARIO_LOGIN => ['email', 'password'],
        ];
    }

    public function getRules(): array
    {
        return [
            [['first_name', 'email', 'password', 'password_repeat'], ValidatorFactory::VALIDATOR_REQUIRED],
            [['email'], ValidatorFactory::VALIDATOR_EMAIL],
            [['email'], ValidatorFactory::VALIDATOR_UNIQUE, 'message' => 'This email address has already been taken.', 'on_scenarios' => self::SCENARIO_REGISTER],
            [['email'], ValidatorFactory::VALIDATOR_STRING, 'min' => 5, 'max' => 100],
            [['first_name', 'last_name'], ValidatorFactory::VALIDATOR_STRING, 'min' => 2, 'max' => 50],
            [['password', 'password_repeat'], ValidatorFactory::VALIDATOR_STRING, 'min' => 6, 'max' => 255],
            [['password_repeat'], 'validatePasswordRepeat', 'message' => 'Passwords do not match'],
            [['email'], ValidatorFactory::VALIDATOR_EXIST, 'targetClass' => static::class, 'targetAttribute' => 'email', 'on_scenarios' => self::SCENARIO_LOGIN, 'message' => 'Invalid email or password'],
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

    public function authenticate(): bool
    {
        $user = db()->find($this->tableName(), ['email' => $this->email])->one();
        if (!$user || !key_exists('password', $user)) {
            return false;
        }
        $this->addError('password', 'Invalid email or password');
        if (!password_verify($this->password, $user['password'])) {
            return false;
        }

        $ua = request()->getUserAgent();
        $userId = $user['id'];
        $userSessionId = app()->security->encrypt("$userId@@@$ua", ENC_KEY);

        $userData = [
            'id' => $userSessionId,
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
        ];

        return (bool)app()->session->set('user', $userData);
    }
}
