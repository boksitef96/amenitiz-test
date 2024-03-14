<?php

namespace Functional\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CashRegisterCalculateCartCommandSuccessTest extends KernelTestCase
{
    /**
     * @dataProvider getProductsDataProvider
     */
    public function testSuccessOneProduct($products, $totalPrice, $discount, $finalPrice, $appliedDiscounts): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = $application->find('cash-register:calculate-cart');
        $tester = new CommandTester($command);

        $tester->execute([
            'products' => $products
        ]);

        $output = $tester->getDisplay();

        $this->assertStringContainsString('Total Price: ' . $totalPrice, $output);
        $this->assertStringContainsString('Discount: ' . $discount, $output);
        $this->assertStringContainsString('Final Price: ' . $finalPrice, $output);

        if (empty($appliedDiscounts)) {
            $this->assertStringNotContainsString('Applied Discounts', $output);
        } else {
            $this->assertStringContainsString('Applied Discounts: ' . $appliedDiscounts, $output);
        }
    }

    public function getProductsDataProvider()
    {
        return [
            // One product
            [['GR1'], '3.11', '0.00', '3.11', null],
            [['SR1'], '5.00', '0.00', '5.00', null],
            [['CF1'], '11.23', '0.00', '11.23', null],

            // Plus one discount two products discount type
            [['GR1', 'GR1'], '6.22', '3.11', '3.11', 'plus_one_discount'],

            // Plus one discount multiple products
            [['GR1', 'GR1', 'GR1', 'GR1', 'GR1', 'GR1'], '18.66', '9.33', '9.33', 'plus_one_discount'],

            // Plus one discount multiple products and others products
            [['GR1', 'GR1', 'GR1', 'GR1', 'GR1', 'GR1', 'SR1'], '23.66', '9.33', '14.33', 'plus_one_discount'],

            // Quantity discount for three products
            [['SR1', 'SR1', 'SR1'], '15.00', '1.50', '13.50', 'quantity_discount'],

            // Quantity discount with other products
            [['SR1', 'SR1', 'SR1', 'CF1'], '26.23', '1.50', '24.73', 'quantity_discount'],

            // Bulk discount for three products
            [['CF1', 'CF1', 'CF1'], '33.69', '11.23', '22.46', 'bulk_discount'],

            // Bulk discount with other products
            [['CF1', 'CF1', 'CF1', 'SR1'], '38.69', '11.23', '27.46', 'bulk_discount'],

            // Mixed products
            [['CF1', 'SR1', 'CF1', 'SR1', 'GR1', 'CF1', 'GR1'], '49.91', '14.34', '35.57', 'bulk_discount, plus_one_discount'],

            // Mixed products
            [['CF1', 'SR1', 'CF1', 'SR1', 'GR1', 'CF1', 'GR1'], '49.91', '14.34', '35.57', 'bulk_discount, plus_one_discount'],

            // Mixed products
            [['SR1', 'SR1', 'GR1', 'SR1'], '18.11', '1.50', '16.61', 'quantity_discount'],

            // Mixed products
            [['GR1', 'CF1', 'SR1' , 'CF1' , 'CF1'], '41.80', '11.23', '30.57', 'bulk_discount'],
        ];
    }
}
