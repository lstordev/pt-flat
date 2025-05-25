<?php

namespace App\Shared\Domain\ValueObject;

abstract class FloatValueObject
{
    public function __construct(protected float $value)
    {
    }

    final public function value(): float
    {
        return $this->value;
    }
}
