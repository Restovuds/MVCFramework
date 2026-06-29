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

        $targetClass = $this->config['targetClass'] ?? null;
        if (!$targetClass) {
            return false;
        }

        $targetAttribute = $this->config['targetAttribute'] ?? null;
        if (!$targetAttribute) {
            return false;
        }

        $query = db()->query("SELECT {$targetAttribute} FROM {$targetClass::tableName()} WHERE {$targetAttribute}=:{$attribute} limit 1", [$attribute => $value]);
        return !!$query->column();
    }
}
