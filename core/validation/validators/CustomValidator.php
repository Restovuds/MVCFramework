<?php

namespace Ocore\validation\validators;

class CustomValidator extends BaseValidator
{
    private mixed $handler;

    public function __construct(mixed $handler, $model, $config = [])
    {
        parent::__construct($model, $config);
        $this->handler = $handler;
    }

    public function validate(mixed $value, ?string $attribute = null): bool
    {
        try {
            return call_user_func([$this->model, $this->handler], attribute: $attribute, config: $this->config);
        } catch (\Throwable $e) {
            return false;
        }
    }
}
