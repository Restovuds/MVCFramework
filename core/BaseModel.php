<?php

namespace Ocore;

abstract class BaseModel
{
    public array $fillable = [];
    public array $attributes = [];

    protected array $errors = [];
    protected array $validators = ['required', 'min', 'max'];

    protected array $errorMessages = [
        'required' => 'This :attribute: is required',
        'min' => 'This :attribute: must be at least :value: characters long',
        'max' => 'This :attribute: must be at most :value: characters long',
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

}