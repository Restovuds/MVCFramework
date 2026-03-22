<?php

namespace Ocore;

class Validators
{
    public const string EMAIL = 'email';
    public const string REQUIRED = 'required';
    public const string MIN = 'min';
    public const string MAX = 'max';


    public const array VALIDATORS_MAP = [
        self::EMAIL => 'emailValidator',
        self::REQUIRED => 'requiredValidator',
        self::MIN => 'minValidator',
        self::MAX => 'maxValidator',
    ];
}