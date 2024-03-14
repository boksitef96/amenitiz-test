# Technical challenge (The Hotel Club project)

## General Information

### Problem to Solve

- You are the developer in charge of building a cash register. This app will be able to add products to a cart and compute the total price.

### Objective
Build an application responding to these needs. By application, we mean:
- It can be a CLI application to run in command line
- It is usable while remaining as simple as possible
- It is simple
- It is readable
- It is maintainable
- It is easily extendable

### Technical requirements
- Code using PHP/Symfony 
- Covered by tests
- Following TDD methodology

### Description and Requirements

Products registered:

- GR1 - Green Tea - 3.11 €
- SR1 - Strawberries - 5.00 € 
- CF1 - Coffee - 11.23 €

Special conditions:
- The CEO is a big fan of buy-one-get-one-free offers and green tea. He wants us to add a rule to do this.
- The COO, though, likes low prices and wants people buying strawberries to get a price discount for bulk purchases. If you buy 3 or more strawberries, the price should drop to 4.50€.
- The VP of Engineering is a coffee addict. If you buy 3 or more coffees, the price of all coffees should drop to 2/3 of the original price.

Our check-out can scan items in any order, and because the CEO and COO change their minds often, it needs to be flexible regarding our pricing rules.


## Getting Started

To get started with building and testing the Hotel Club Symfony project, follow these steps:

1. Download this project repository to your local development environment.

2. Ensure you have PHP8, Composer and SymfonyCLI installed on your system.

3. Navigate to the project directory and run:
```shell
composer install
```

4. Start application
```shell
symfony server:start
```

5. Run CartCalculate command
```shell
bin/console cash-register:calculate-cart GR1 CF1 SR1
```

6. Run tests
```shell
composer test
```

## Additional Notes

The goal of the project is to calculate cart sum and display as CLI output. 

It is possible to have multiple type of discounts: plus_one_discount, quantity_discount and bulk_discount.

Since this project should be simple and only run calculation for card and output to CLI I didn't integrate database logic. 
We could assume that in real usage we would have some way of CMS where we could manipulate with products and also define discounts and their related data. 
Later cash register app will fetch those data through API or integrated SDK and work with real data. 

I will simulate data from db with json files for products and discounts, and they are stored in app/data directory.

Each product could have one or more discounts connected and if conditions are full-filled it will be applied.
For now, we only have in jsons three products and three discounts as it is in requirements and in example.
It is easy to add new discount type and handler, just need to add new connected discount service which will implements base DiscountTypeInterface.

It is possible also to customize discount handling by adding some custom data to Discount.additional_data (in json). 
I added for now some basic info needed for current three discounts.

Output on the end shows all info related to total price (without discounts), final price and discounts data.

Example:

```shell
$ bin/console cash-register:calculate-cart SR1 SR1 GR1 SR1

[INFO] Calculating total price for products: SR1, SR1, GR1, SR1


[OK] Total Price: 18.11 €
    Discount: 1.50 €
    Applied Discounts: quantity_discount
    Final Price: 16.61 €
```

