@receiving_discount
Feature: Receiving fixed discount from cart promotions only on non discounted products
    In order not to combine cart and catalog promotions
    As a Store Owner
    I want to apply discount only on products that are non discounted

    Background:
        Given the store operates on a single channel in "United States"
        And the store has a product "Mug" priced at "$40.00"
        And the store has a product "T-Shirt" priced at "$20.00"
        And the store has a product "Cap" priced at "$10.00"
        And there is a catalog promotion "Winter sale" that reduces price by "25%" and applies on "T-Shirt" product

    @api @ui @mink:chromedriver
    Scenario: Receiving product discount from cart promotions also on discounted products
        Given there is a promotion "Christmas sale" that applies to discounted products
        And this promotion gives "$10.00" off on every product priced between "$10.00" and "$50.00"
        When the customer adds "T-Shirt" product to the cart
        And the customer adds "Mug" product to the cart
        Then the product "T-Shirt" should have discounted unit price "$5.00" in the cart
        And the product "Mug" should have discounted unit price "$30.00" in the cart
        And my cart total should be "$35.00"

    @api @ui @mink:chromedriver
    Scenario: Receiving product discount from cart promotions only on non discounted products
        Given there is a promotion "Christmas sale" that does not apply to discounted products
        And this promotion gives "$10.00" off on every product priced between "$10.00" and "$50.00"
        When the customer adds "T-Shirt" product to the cart
        And the customer adds "Mug" product to the cart
        Then the product "T-Shirt" should have discounted unit price "$15.00" in the cart
        And the product "Mug" should have discounted unit price "$30.00" in the cart
        And the cart total should be "$45.00"

    @api @no-ui
    Scenario: Receiving order discount from cart promotions distributed only on non discounted products
        Given there is a promotion "Christmas sale" that does not apply to discounted products
        And this promotion gives "$10.00" discount to every order
        When the customer adds "T-Shirt" product to the cart
        And the customer adds "Mug" product to the cart
        And the customer adds "Cap" product to the cart
        Then the product "T-Shirt" should have discounted unit price "$15.00" in the cart
        And the product "Mug" should have total price "$32.00" in the cart
        And the product "Cap" should have total price "$8.00" in the cart
        And the cart total should be "$55.00"
