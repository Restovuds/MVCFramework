<?php

namespace Ocore\validation\validators;

trait MinMaxTrait
{
    public function checkMinMax(mixed $value): bool|int
    {
        if ($this->config['min'] && $this->config['max']) {
            return $value >= $this->config['min'] && $value <= $this->config['max'];
        }

        if ($this->config['min'] && $value < $this->config['min']) {
            return false;
        }

        if ($this->config['max'] && $value > $this->config['max']) {
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
