<?php

namespace Ocore;

abstract class BaseModel
{
    public array $fillable = [];
    public array $attributes = [];

    public array $rules = [];

    protected array $errors = [];

    protected array $errorMessages = [
        Validators::REQUIRED => ':attribute: is required',
        Validators::MIN => ':attribute: must be at least :value: characters long',
        Validators::MAX => ':attribute: must be at most :value: characters long',
        Validators::EMAIL => ':attribute: must be a valid email address',
    ];

    public function load(): bool
    {
        $data = request()->getData();

        foreach ($this->fillable as $f) {
            if (isset($data[$f])) {
                $this->attributes[$f] = $data[$f];
            } else {
                $this->attributes[$f] = null;
            }
        }

        return true;
    }
    public function validate(): bool
    {
        foreach ($this->attributes as $attribute => $value) {
            if (isset($this->rules[$attribute])) {
                $this->checkValidator([
                    'attribute' => $attribute,
                    'value' => $value,
                    'rules' => $this->rules[$attribute]
                ]);
            }
        }

        if (!empty($this->errors)) {
            return false;
        }

        return true;
    }

    protected function checkValidator(array $field): void
    {
        foreach ($field['rules'] as $ruleName => $ruleValue) {
            if (is_int($ruleName)) {
                $ruleName = $ruleValue;
            }
            if (in_array($ruleName, array_keys(Validators::VALIDATORS_MAP))) {
                if (!call_user_func_array([$this, Validators::VALIDATORS_MAP[$ruleName]], [$field['value'], $ruleValue])) {
                    $this->errors[$field['attribute']][] = str_replace(
                        [':attribute:', ':value:'],
                        [$field['attribute'], $ruleValue],
                        $this->errorMessages[$ruleName]
                    );
                }
            }
        }
    }

    protected function requiredValidator(mixed $value, $ruleValue = null): bool
    {
        return !empty(trim($value));
    }

    protected function minValidator(string $value, $ruleValue): bool
    {
        return mb_strlen($value, 'UTF-8') >= $ruleValue;
    }

    protected function maxValidator(string $value, $ruleValue): bool
    {
        return mb_strlen($value, 'UTF-8') <= $ruleValue;
    }

    protected function emailValidator(mixed $value, $ruleValue = null): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

}