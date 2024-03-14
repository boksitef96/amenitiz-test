<?php

namespace App\Service;

use App\Entity\Discount;
use App\Entity\Product;
use JMS\Serializer\SerializerInterface;

class CartService
{
    public function __construct(private SerializerInterface $serializer, private DiscountService $discountService)
    {
    }

    /**
     * @param  array  $inputData
     *
     * @return void
     */
    public function calculateCartPrice(array $inputData)
    {
        $cartData = $this->prepareCartData($inputData);
        $cartData = $this->discountService->applyDiscountToCart($cartData);
    }

    /**
     * @return array
     */
    public function getAllProductsData(): array
    {
        $productsJsonContent = file_get_contents('data/products.json');
        $discountsJsonContent = file_get_contents('data/discounts.json');

        $productsData = $this->serializer->deserialize($productsJsonContent, 'array<' . Product::class . '>', 'json');
        $discountsData = $this->serializer->deserialize($discountsJsonContent, 'array<' . Discount::class . '>', 'json');

        return [$productsData, $discountsData];
    }

    /**
     * @param $inputData
     *
     * @return array
     */
    public function prepareCartData($inputData): array
    {
        [$productsData, $discountsData] = $this->getAllProductsData();

        $cartData = [];
        foreach ($inputData as $cartItem) {
            if (empty($cartData[$cartItem])) {
                /** @var Product $productData */
                $productData = array_values(array_filter($productsData, function (Product $value) use ($cartItem) {
                        return $value->getCode() === $cartItem;
                    }))[0] ?? null;
                if (empty($productData)) {
                    dd("error");
                }

                $discountData = array_filter($discountsData, function (Discount $value) use ($cartItem) {
                        return $value->getProductCode() === $cartItem;
                    }) ?? [];
                $cartData[$cartItem] = [
                    'quantity'           => 0,
                    'price'              => $productData->getPrice(),
                    'availableDiscounts' => $discountData
                ];
            }

            $cartData[$cartItem]['quantity'] += 1;
            $cartData[$cartItem]['totalPrice'] = $cartData[$cartItem]['quantity'] * $cartData[$cartItem]['price'];
        }

        return $cartData;
    }
}
