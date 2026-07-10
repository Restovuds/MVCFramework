<?php

namespace Ocore\validation\validators;

class UniqueValidator extends BaseValidator
{
    public string $errorMessage = ':attribute: must be an unique value';

    public function validate(mixed $value, string|null $attribute = null): bool
    {
        if ($this->model->hasErrors()) {
            return true; // Skip extra db query validation if the model has errors
        }

        $withId = $this->model?->id ? "AND id != :id" : '';
        $query = db()->query("SELECT {$attribute} FROM {$this->model::tableName()} WHERE {$attribute}=:{$attribute} {$withId} limit 1", array_merge([$attribute => $value], $withId ? [':id' => $this->model->id] : []));
        return !$query->column();
    }
}
