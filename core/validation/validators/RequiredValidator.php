<?php

namespace Ocore\validation\validators;

class RequiredValidator extends BaseValidator
{
    public string $errorMessage = ':attribute: is required';

    public function validate(mixed $value, string|null $attribute = null): bool
    {
        if (is_array($value)) {
            return !empty($value);
        }
        if (is_null($value)) {
            return false;
        }
        return !empty(trim((string)$value));
    }
}
