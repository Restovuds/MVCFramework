<?php

namespace Ocore\validation\validators;

class RequiredValidator extends BaseValidator
{
    public string $errorMessage = ':attribute: is required';

    public function validate(mixed $value, string|null $attribute = null): bool
    {
        return !empty(trim($value));
    }
}
