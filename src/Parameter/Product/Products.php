<?php

namespace Omnipay\Sebes\Parameter\Product;

class Products
{
    private array $products;

    public function __construct(array $products = [])
    {
        $this->products = $products;
    }

    public function add(Product $product)
    {
        $this->products[] = $product;
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}
