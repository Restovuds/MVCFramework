<?php

namespace Ocore\validation\validators;

use Ocore\exception\ValidatorException;

class CustomValidator extends BaseValidator
{
    private mixed $handler;

    public function __construct(mixed $handler, $model, $config = [])
    {
        parent::__construct($model, $config);
        $this->handler = $handler;
    }

    /**
     * @throws ValidatorException
     */
    public function validate(mixed $value, ?string $attribute = null): bool
    {
        try {
            return call_user_func([$this->model, $this->handler], attribute: $attribute, config: $this->config);
        } catch (\Throwable $e) {
            $class = $this->model::class;
            throw new ValidatorException("Class {$class} does not have a {$this->handler} method");
        }
    }
}
