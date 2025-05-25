<?php

namespace App\Product\Domain;

use App\Shared\Domain\Collection;

class Products extends Collection
{
    protected function type(): string
    {
        return Product::class;
    }
}
