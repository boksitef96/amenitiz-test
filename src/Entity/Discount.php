<?php

namespace App\Entity;

class Discount
{
    private string $type;
    private array $additionalData;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getAdditionalData(): array
    {
        return $this->additionalData;
    }
}
