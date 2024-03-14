<?php

namespace App\Enums;

enum DiscountTypeEnum: string
{
    case PLUS_ONE_DISCOUNT = 'plus_one_discount';
    case BULK_DISCOUNT = 'bulk_discount';
    case QUANTITY_DISCOUNT = 'quantity_discount';

    /**
     * @return array<int>
     */
    public static function getAllValues(): array
    {
        return [
            self::PLUS_ONE_DISCOUNT->value,
            self::BULK_DISCOUNT->value,
            self::QUANTITY_DISCOUNT->value,
        ];
    }
}
