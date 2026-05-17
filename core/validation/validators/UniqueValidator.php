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

        $query = db()->query("SELECT * FROM {$this->model::tableName()} WHERE {$attribute}=:{$attribute} limit 1", [$attribute => $value]);
        $result = (bool)$query->asArray(true);
        return !$result;
    }
}
