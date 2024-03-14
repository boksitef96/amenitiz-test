<?php

namespace Functional\Command;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class CashRegisterCalculateCartCommandFailureTest extends KernelTestCase
{
    public function testEmptyCart(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = $application->find('cash-register:calculate-cart');
        $tester = new CommandTester($command);

        $tester->execute([
            'products' => []
        ]);

        $output = $tester->getDisplay();

        $this->assertStringContainsString('No products provided', $output);
    }

    public function testWrongProductCode(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = $application->find('cash-register:calculate-cart');
        $tester = new CommandTester($command);

        $tester->execute([
            'products' => ['test']
        ]);

        $output = $tester->getDisplay();

        $this->assertStringContainsString('There is a problem calculating your price', $output);
        $this->assertStringContainsString('Product not found', $output);
    }

    public function testWrongAndValidProductCode(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = $application->find('cash-register:calculate-cart');
        $tester = new CommandTester($command);

        $tester->execute([
            'products' => ['GR1', 'test']
        ]);

        $output = $tester->getDisplay();

        $this->assertStringContainsString('There is a problem calculating your price', $output);
        $this->assertStringContainsString('Product not found', $output);
    }
}
