<?php

namespace App\Service\DiscountType;

use App\Entity\Discount;
use App\Enums\DiscountTypeEnum;

class PlusOneDiscountService implements DiscountTypeInterface
{
    public function isApplicable(array $productData, Discount $discountData): bool
    {
        // Check if the quantity is at least 2
        if ($productData['quantity'] < 2) {
            return false;
        }

        return true;
    }

    public function applyDiscount(array $productData, Discount $discountData): array
    {
        $productData = [
            ...$productData,
            'discount'         => $productData['discount'] ?? 0,
            'appliedDiscounts' => $productData['appliedDiscounts'] ?? []
        ];

        // Calculate how many sets for it can be applied
        $setsOfTwo = intval($productData['quantity'] / 2);

        // Calculate the total discount
        $discount = $productData['discount'] + $productData['price'] * $setsOfTwo;

        // Update productData with discount and final price
        $productData['discount'] = $discount;
        $productData['finalPrice'] = $productData['totalPrice'] - $discount;
        $productData['appliedDiscounts'][] = DiscountTypeEnum::PLUS_ONE_DISCOUNT->value; // Log applied discount

        // Return updated productData
        return $productData;
    }
}