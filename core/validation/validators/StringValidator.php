<?php

namespace Ocore\validation\validators;

class StringValidator extends BaseValidator
{
    public string $errorMessage = ':attribute: must be an string';
    public string $maxErrorMessage = ':attribute: must be longer than :min:';
    public string $minErrorMessage = ':attribute: must be shorter than :max:';
    public string $betweenErrorMessage = ':attribute: must be between :min: and :max:';

    use MinMaxTrait;
    public function validate(mixed $value, string|null $attribute = null): bool
    {
        $minMax = $this->checkMinMax(strlen($value));
        if ($minMax !== -1) {
            return $minMax;
        }

        return true;
    }

    public function getErrorMessage($attribute, $value): string
    {
        $this->minMaxErrors($value);
        return parent::getErrorMessage($attribute, $value);
    }
}
