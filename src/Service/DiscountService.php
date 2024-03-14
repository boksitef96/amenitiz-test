<?php

namespace App\Service;

use App\Entity\Discount;
use App\Enums\DiscountTypeEnum;
use App\Service\DiscountType\BulkDiscountService;
use App\Service\DiscountType\DiscountTypeInterface;
use App\Service\DiscountType\PlusOneDiscountService;
use App\Service\DiscountType\QuantityDiscountService;

class DiscountService
{
    public function __construct(private PlusOneDiscountService $plusOneDiscountService, private BulkDiscountService $bulkDiscountService, private QuantityDiscountService $quantityDiscountService)
    {
    }

    public function applyDiscountToCart($cartData)
    {
        foreach ($cartData as $key => $productData) {
            foreach ($productData['availableDiscounts'] as $discount) {
                $discountService = $this->getDiscountService($discount);
                if (empty($discountService)) {
                    continue;
                }
                if (!$discountService->isApplicable($productData, $discount)) {
                    continue;
                }
                $productData = $discountService->applyDiscount($productData, $discount);
            }

            $cartData[$key] = $productData;
        }

        return $cartData;
    }

    public function getDiscountService(Discount $discount): ?DiscountTypeInterface
    {
        return match ($discount->getType()) {
            DiscountTypeEnum::PLUS_ONE_DISCOUNT->value => $this->plusOneDiscountService,
            DiscountTypeEnum::BULK_DISCOUNT->value => $this->bulkDiscountService,
            DiscountTypeEnum::QUANTITY_DISCOUNT->value => $this->quantityDiscountService,
            default => null,
        };
    }
}
