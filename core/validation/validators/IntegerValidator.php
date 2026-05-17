<?php

namespace Ocore\validation\validators;

class IntegerValidator extends BaseValidator
{
    public string $errorMessage = ':attribute: must be an integer';
    public string $maxErrorMessage = ':attribute: must be greater than :min:';
    public string $minErrorMessage = ':attribute: must be less than :max:';
    public string $betweenErrorMessage = ':attribute: must be between :min: and :max:';

    use MinMaxTrait;

    public function validate(mixed $value, string|null $attribute = null): bool
    {
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            return false;
        }

        $minMax = $this->checkMinMax($value);
        if ($minMax !== -1) {
            return $minMax;
        }

        return true;
    }

    public function getErrorMessage($attribute, $value): string
    {
        $fromTrait = $this->minMaxErrors($value);
        if ($fromTrait) {
            parent::getErrorMessage($attribute, $value);
        }
        return parent::getErrorMessage($attribute, $value);
    }
}
