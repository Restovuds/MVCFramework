<?php

namespace Ocore\validation\validators;

use Ocore\BaseModel;

abstract class BaseValidator
{
    public string $errorMessage = "Invalid value";
    public BaseModel $model;
    public array $config = [];
    protected bool $useCustomMessage = false;

    public function __construct($model, $config = [])
    {
        $this->model = $model;
        $this->config = $config;

        if (isset($config['message'])) {
            $this->useCustomMessage = true;
            $this->errorMessage = $config['message'];
        }
    }

    abstract public function validate(mixed $value, string|null $attribute = null): bool;

    public function getErrorMessage($attribute, $value): string
    {
        $message = $this->config['message'] ?? $this->errorMessage;
        $messageParams = $this->config['messageConfig'] ?? [];

        $a = array_merge([':attribute:', ':value:'], array_keys($messageParams));
        $b = array_merge([$this->model->getAttributeLabel($attribute), $value], array_values($messageParams));

        foreach ($b as &$value) {
            if (is_array($value) && empty($value)) {
                $value = '';
            }
        }

        return str_replace($a, $b, $message);
    }
}
