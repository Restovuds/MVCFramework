<?php

namespace Ocore\validation\validators;

class EmailValidator extends BaseValidator
{
    public string $errorMessage = ':attribute: must be a valid email address';

    public function validate(mixed $value, string|null $attribute = null): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
