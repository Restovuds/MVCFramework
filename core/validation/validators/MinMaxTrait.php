<?php

namespace Ocore\validation\validators;

trait MinMaxTrait
{
    public function checkMinMax(mixed $value): bool|int
    {
        if ((key_exists('min', $this->config) && $this->config['min']) && (key_exists('max', $this->config) && $this->config['max'])) {
            return $value >= $this->config['min'] && $value <= $this->config['max'];
        }

        if (key_exists('min', $this->config) && $this->config['min'] && $value < $this->config['min']) {
            return false;
        }

        if (key_exists('man', $this->config) && $this->config['max'] && $value > $this->config['max']) {
            return false;
        }

        return -1;
    }

    public function minMaxErrors(mixed $value): bool
    {
        $minOrMax = false;
        if ($this->config['min'] && $this->config['max'] && !$this->useCustomMessage) {
            $this->errorMessage = $this->betweenErrorMessage;
            $minOrMax = true;
        }

        if ($this->config['min'] && $value < $this->config['min'] && !$this->useCustomMessage && !$minOrMax) {
            $this->errorMessage = $this->minErrorMessage;
            $minOrMax = true;
        }

        if ($this->config['max'] && $value > $this->config['max'] && !$this->useCustomMessage && !$minOrMax) {
            $this->errorMessage = $this->maxErrorMessage;
            $minOrMax = true;
        }

        if ($minOrMax) {
            $this->errorMessage = str_replace([':min:', ':max:'], [$this->config['min'], $this->config['max']], $this->errorMessage);
        }

        return $minOrMax;
    }
}
