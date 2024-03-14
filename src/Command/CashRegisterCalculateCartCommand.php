<?php

namespace App\Command;

use App\Service\CartService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'cash-register:calculate-cart',
    description: 'Calculate the total price of products in the cart',
)]
class CashRegisterCalculateCartCommand extends Command
{
    public function __construct(private CartService $cartService, ?string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('products', InputArgument::IS_ARRAY, 'List of product codes separated by spaces');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $products = $input->getArgument('products');

        if (empty($products)) {
            $io->error('No products provided.');

            return Command::SUCCESS;
        }

        $io->info('Calculating total price for products: ' . implode(', ', $products));

        $this->cartService->getCartPrice($products);

        return Command::SUCCESS;
    }
}
