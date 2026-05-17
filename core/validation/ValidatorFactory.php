<?php

namespace Ocore\validation;

use Ocore\validation\validators\BaseValidator;
use Ocore\validation\validators\CustomValidator;
use Ocore\validation\validators\EmailValidator;
use Ocore\validation\validators\IntegerValidator;
use Ocore\validation\validators\RequiredValidator;
use Ocore\validation\validators\StringValidator;
use Ocore\validation\validators\UniqueValidator;
use Ocore\BaseModel;

class ValidatorFactory
{
    public const string VALIDATOR_REQUIRED = 'required';
    public const string VALIDATOR_EMAIL = 'email';
    public const string VALIDATOR_INTEGER = 'integer';
    public const string VALIDATOR_UNIQUE = 'unique';
    public const string VALIDATOR_STRING = 'string';


    private static array $validators = [
        self::VALIDATOR_REQUIRED => RequiredValidator::class,
        self::VALIDATOR_EMAIL => EmailValidator::class,
        self::VALIDATOR_INTEGER => IntegerValidator::class,
        self::VALIDATOR_UNIQUE => UniqueValidator::class,
        self::VALIDATOR_STRING => StringValidator::class,
    ];

    public static function createValidator(mixed $validator, BaseModel $model, $config = []): BaseValidator
    {
        if (in_array($validator, array_keys(self::$validators))) {
            return new self::$validators[$validator]($model, $config);
        } else {
            return new CustomValidator($validator, $model, $config);
        }
    }
}
