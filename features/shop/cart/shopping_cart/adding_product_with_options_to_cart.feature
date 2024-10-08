@shopping_cart
Feature: Adding a product with selected option to the cart
    In order to select specific variant of product for purchase
    As a Visitor
    I want to be able to add products with selected options to cart

    Background:
        Given the store operates on a single channel in "United States"
        And the store has a product "T-Shirt banana"
        And this product has option "Size" with values "S" and "M"
        And this product has all possible variants

    @api @ui @javascript
    Scenario: Adding a product with single option to the cart
        When I add "T-Shirt banana" with Size "M" to the cart
        Then I should be on my cart summary page
        And I should be notified that the product has been successfully added
        And there should be one item in my cart
        And this item should have name "T-Shirt banana"
        And this product should have Size "M"
