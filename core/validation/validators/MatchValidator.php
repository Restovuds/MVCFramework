<?php

namespace Ocore\validation\validators;

use Ocore\validation\validators\BaseValidator;

class MatchValidator extends BaseValidator
{

    /**
     * @inheritDoc
     */
    public function validate(mixed $value, ?string $attribute = null): bool
    {
        $pattern = $this->config['pattern'] ?? null;
        if ($value && $pattern) {
            return (bool)preg_match($pattern, $value);
        }
        return false;
    }
}
