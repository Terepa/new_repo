<?php

namespace App\Helper;

class Product
{
    public function __construct(
        private int $price,
        private string $name,
    ){

    }

    public static function fromResult(array $result): self
    {
        return new self(
            (int)$result['price'],
            $result['name'],
        );
    }
}