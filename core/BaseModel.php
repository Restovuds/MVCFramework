<?php

namespace Ocore;

use Ocore\validation\ValidatorFactory;
use Ocore\validation\validators\BaseValidator;

abstract class BaseModel
{
    public array $attributes = [];

    protected array $errors = [];


    /**
     * Provides the name of the database table associated with the model or class.
     *
     * @return string The name of the database table.
     */
    abstract public static function tableName(): string;


    /**
     * Retrieves the set of rules.
     *
     * @return array An array containing the defined rules.
     */
    public function getRules(): array
    {
        return [];
    }

    /**
     * Retrieves the attribute labels.
     *
     * @return array An array containing the attribute labels.
     */
    protected function attributeLabels(): array
    {
        return [];
    }

    public function getAttributes(): array
    {
        $rules = $this->getRules();
        $attributes = [];
        foreach ($rules as $rule) {
            if (is_array($rule[0])) {
                $attributes = array_merge($attributes, $rule[0]);
            } else {
                $attributes[] = $rule[0];
            }
        }

        return array_unique($attributes);
    }

    public function __get(string $name): mixed
    {
        if (in_array($name, $this->getAttributes())) {
            return $this->attributes[$name];
        }

        return null;
    }

    public function __set(string $name, mixed $value): void
    {
        if (in_array($name, $this->getAttributes())) {
            $this->attributes[$name] = $value;
        } else {
            throw new \Exception("Property {$name} does not exist in class " . get_class($this));
        }
    }

    public function __unset(string $name): void
    {
        if (isset($this->attributes[$name])) {
            unset($this->attributes[$name]);
        }
    }

    /**
     * Retrieves the label for a specific attribute.
     *
     * @param string $attribute The name of the attribute for which the label is being retrieved.
     * @return string The label corresponding to the specified attribute, or the attribute name itself if no label is defined.
     */
    public function getAttributeLabel($attribute): string
    {
        return $this->attributeLabels()[$attribute] ?? $attribute;
    }

    public function save($runValidation = true): false|string
    {
        if ($runValidation && !$this->validate()) {
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

    public function load($data = null): bool
    {
        $data = is_null($data) ? request()->getData() : $data;

        foreach ($this->getAttributes() as $f) {
            if (isset($data[$f])) {
                $this->attributes[$f] = $data[$f];
            } else {
                $this->attributes[$f] = null;
            }
        }

        if (key_exists('id', $data)) {
            $this->attributes['id'] = $data['id'];
        }

        return true;
    }

    /**
     * Validates the attributes of the model based on the defined rules.
     *
     * @return bool True if the validation passes without errors, otherwise false.
     */
    public function validate(): bool
    {
        $rules = $this->getRules();

        foreach ($rules as $rule) {
            $attrToValidate = $rule[0];
            $ruleName = $rule[1];
            $config = array_slice($rule, 2);

            $validator = ValidatorFactory::createValidator($ruleName, $this, $config);

            if (is_array($attrToValidate)) {
                foreach ($attrToValidate as $attr) {
                    $this->validateAttribute($validator, $this->attributes[$attr], $attr);
                }
            } else {
                $this->validateAttribute($validator, $this->attributes[$attrToValidate], $attrToValidate);
            }

        }

        return !$this->hasErrors();
    }

    private function validateAttribute(BaseValidator $validator, mixed $value, string|null $attribute): void
    {
        $validationFailed = !$validator->validate($value, $attribute);
        if ($validationFailed) {
            $this->addError($attribute, $validator->getErrorMessage($attribute, $value));
        }
    }

    public function delete(int $id): bool
    {
        $query = "DELETE FROM {$this::tableName()} WHERE id=:id";
        db()->query($query, compact('id'));
        return !!db()->affectedRows();
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
}