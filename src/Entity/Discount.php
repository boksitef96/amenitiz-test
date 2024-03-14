<?php

namespace App\Entity;

class Discount
{
    private string $type;
    private string $productCode = '';
    private DiscountAdditionalData $additionalData;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getProductCode(): string
    {
        return $this->productCode;
    }

    /**
     * @return DiscountAdditionalData
     */
    public function getAdditionalData(): DiscountAdditionalData
    {
        return $this->additionalData;
    }
}

class DiscountAdditionalData
{
    private float $threshold;
    private ?float $discountPercent;
    private ?float $discountPrice;

    /**
     * @return float
     */
    public function getThreshold(): float
    {
        return $this->threshold;
    }

    /**
     * @return float|null
     */
    public function getDiscountPercent(): ?float
    {
        return $this->discountPercent;
    }

    /**
     * @return float|null
     */
    public function getDiscountPrice(): ?float
    {
        return $this->discountPrice;
    }
}
