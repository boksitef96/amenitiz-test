<?php

namespace App\Service\DiscountType;

use App\Entity\Discount;

interface DiscountTypeInterface
{
    public function isApplicable(array $productData, Discount $discountData): bool;

    public function applyDiscount(array $productData, Discount $discountData): array;
}