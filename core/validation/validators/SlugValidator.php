<?php

namespace Ocore\validation\validators;

class SlugValidator extends BaseValidator
{
    public string $errorMessage = ":attribute: must be a valid slug";

    /**
     * @inheritDoc
     */
    public function validate(mixed $value, ?string $attribute = null): bool
    {
        $pattern = $this->config['pattern'] ?? '/^[a-z0-9-]+$/'; // allow configuring your own pattern for slug validation

        $matchValidator = new MatchValidator($this->model, array_merge($this->config, ['pattern' => $pattern]));
        return $matchValidator->validate($value, $attribute);
    }
}
