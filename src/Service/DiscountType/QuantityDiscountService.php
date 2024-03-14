<?php

namespace App\Service\DiscountType;

use App\Entity\Discount;
use App\Enums\DiscountTypeEnum;

class QuantityDiscountService implements DiscountTypeInterface
{
    public function isApplicable(array $productData, Discount $discountData): bool
    {
        // Check if the quantity is more than set threshold
        return $productData['quantity'] >= $discountData->getAdditionalData()?->getThreshold();
    }

    public function applyDiscount(array $productData, Discount $discountData): array
    {
        $productData = [
            ...$productData,
            'discount'         => $productData['discount'] ?? 0,
            'appliedDiscounts' => $productData['appliedDiscounts'] ?? []
        ];

        // calculate new price for products
        $newPrice = $productData['quantity'] * $discountData->getAdditionalData()?->getDiscountPrice();

        // Calculate the total discount
        $discount = $productData['discount'] + $productData['totalPrice'] - $newPrice;

        // Update productData with discount and final price
        $productData['discount'] = $discount;
        $productData['finalPrice'] = $productData['totalPrice'] - $discount;
        $productData['appliedDiscounts'][] = DiscountTypeEnum::QUANTITY_DISCOUNT->value; // Log applied discount

        return $productData;
    }
}
