<?php

namespace Ocore;

use Ocore\validation\ValidatorFactory;
use Ocore\validation\validators\BaseValidator;

abstract class BaseModel
{
    const string SCENARIO_DEFAULT = 'default';
    public array $attributes = [];
    public string $scenario = self::SCENARIO_DEFAULT;

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
     * Declares validation scenarios as a map of scenario name to the list of
     * attributes that are "active" (loaded and validated) in that scenario.
     *
     * By default every model has a single {@see self::SCENARIO_DEFAULT} scenario
     * covering all attributes, so existing models keep working unchanged.
     * Override this method to add scenarios, e.g.:
     *
     *   return [
     *       self::SCENARIO_DEFAULT => ['title', 'body', 'slug'],
     *       'create'              => ['title', 'body', 'slug'],
     *       'search'              => ['title'],
     *   ];
     *
     * @return array<string, string[]>
     */
    public function scenarios(): array
    {
        return [
            self::SCENARIO_DEFAULT => $this->getAttributes(),
        ];
    }

    /**
     * Sets the current scenario and returns the model for chaining.
     */
    public function setScenario(string $scenario): static
    {
        $this->scenario = $scenario;
        return $this;
    }

    /**
     * Returns the attributes that are active in the current scenario.
     *
     * @return string[]
     * @throws \Exception when the current scenario is not declared.
     */
    public function activeAttributes(): array
    {
        $scenarios = $this->scenarios();
        if (!isset($scenarios[$this->scenario])) {
            throw new \Exception(
                "Unknown scenario '{$this->scenario}' in " . get_class($this)
            );
        }

        return $scenarios[$this->scenario];
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

        foreach ($this->activeAttributes() as $f) {
            $this->attributes[$f] = $data[$f] ?? null;
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
    public function validate(string|array $attributesToValidate = []): bool
    {
        $this->errors = [];

        $active = $this->activeAttributes();

        $requested = (array)$attributesToValidate;
        $filter = empty($requested) ? $active : array_intersect($requested, $active);

        foreach ($this->getRules() as $rule) {
            $ruleAttributes = is_array($rule[0]) ? $rule[0] : [$rule[0]];
            $ruleName = $rule[1];
            $config = array_slice($rule, 2);

            if ($this->scenario !== self::SCENARIO_DEFAULT) {
                $ruleScenarios = $config['on_scenarios'] ?? [self::SCENARIO_DEFAULT];
                $ruleScenarios = is_string($ruleScenarios) ? [$ruleScenarios] : $ruleScenarios;
                if (!in_array($this->scenario, $ruleScenarios) && !in_array(self::SCENARIO_DEFAULT, $ruleScenarios)) {
                    continue;
                }
            }

            $attributes = array_intersect($ruleAttributes, $filter);
            if (empty($attributes)) {
                continue;
            }

            $validator = ValidatorFactory::createValidator($ruleName, $this, $config);
            foreach ($attributes as $attr) {
                $this->validateAttribute($validator, $this->attributes[$attr] ?? null, $attr);
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