<?php

namespace App\Service\DiscountType;

interface DiscountTypeInterface
{
    public function isApplicable(array $productData);

    public function applyDiscount(array $productData): array;
}