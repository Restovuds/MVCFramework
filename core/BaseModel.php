<?php

namespace Ocore;

abstract class BaseModel
{
    public array $fillable = [];
    public array $attributes = [];

    public array $rules = [];
    public array $attributeLabels = [];

    protected array $errors = [];

    public static function tableName(): string
    {
        return '';
    }

    protected array $errorMessages = [
        Validators::REQUIRED => ':attribute: is required',
        Validators::MIN => ':attribute: must be at least :value: characters long',
        Validators::MAX => ':attribute: must be at most :value: characters long',
        Validators::EMAIL => ':attribute: must be a valid email address',
    ];

    public function save($runValidation = true): false|string
    {
        if($runValidation && !$this->validate()) {
            return false;
        }

        // fields
        $fields = implode(
            ', ',
            array_map(
                fn($i) => "`{$i}`",
                array_keys($this->attributes)
            )
        );

        // values
        $placeholders = implode(
            ', ',
            array_map(
                fn($i) => ":{$i}",
                array_keys($this->attributes)
            )
        );

        $query = "INSERT INTO {$this::tableName()} ({$fields}) VALUES ({$placeholders})";
        db()->query($query, $this->attributes);

        return db()->getInsertId();
    }

    public function update(): bool
    {
        if (!isset($this->attributes['id'])) {
            return false;
        }

        $fields = '';
        foreach ($this->attributes as $f => $v) {
            if ($f === 'id') {
                continue;
            }
            $fields .= "`{$f}`=:{$f},";
        }
        $fields = rtrim($fields, ',');

        $query = "UPDATE {$this::tableName()} SET {$fields} WHERE id=:id";
        return !!db()->query($query, $this->attributes);
    }

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

        return !$this->hasErrors();
    }

    public function delete(int $id): bool
    {
        $query = "DELETE FROM {$this::tableName()} WHERE id=:id";
        db()->query($query, compact('id'));
        return !!db()->affectedRows();
    }

    protected function checkValidator(array $field): void
    {
        foreach ($field['rules'] as $ruleName => $ruleValue) {
            if (is_int($ruleName)) {
                $ruleName = $ruleValue;
            }
            if (in_array($ruleName, array_keys(Validators::VALIDATORS_MAP))) {
                if (!call_user_func_array([$this, Validators::VALIDATORS_MAP[$ruleName]], [$field['value'], $ruleValue])) {
                    $this->addError($field['attribute'], str_replace(
                        [':attribute:', ':value:'],
                        [$this->getAttributeLabel($field['attribute']), $ruleValue],
                        $this->errorMessages[$ruleName]
                    ));
                }
            }
        }
    }

    public function getAttributeLabel($attribute): string
    {
        return $this->attributeLabels[$attribute] ?? $attribute;
    }

    public function addError(string $attribute, string $message): void
    {
        $this->errors[$attribute][] = $message;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getErrorsAsArray(): array
    {
        return array_map(function ($messages) {
            return implode(', ', $messages);
        }, $this->errors);
    }

    public function getErrorsAsHtml(): string
    {
        $output = '<ul class="list-unstyled">';
        foreach ($this->errors as $fieldErrors) {
            foreach ($fieldErrors as $error) {
                $output .= "<li>{$error}</li>";
            }
        }
        $output .= '</ul>';
        return $output;
    }


    public function hasErrors(): bool
    {
        return !empty($this->errors);
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