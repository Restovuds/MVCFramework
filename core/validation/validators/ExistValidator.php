<?php

namespace Ocore\validation\validators;

class ExistValidator extends BaseValidator
{
    public string $errorMessage = ':attribute: must exist';


    public function validate(mixed $value, ?string $attribute = null): bool
    {
        if ($this->model->hasErrors()) {
            return true; // Skip extra db query validation if the model has errors
        }

        $query = db()->query("SELECT {$attribute} FROM {$this->model::tableName()} WHERE {$attribute}=:{$attribute} limit 1", [$attribute => $value]);
        return !!$query->column();
    }
}
