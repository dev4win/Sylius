@managing_promotions
Feature: Adding a new promotion with action
    In order to give possibility to pay specifically less price for some goods
    As an Administrator
    I want to add a new promotion with action to the registry

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @api @ui @mink:chromedriver
    Scenario: Adding a new promotion with fixed discount
        When I want to create a new promotion
        And I specify its code as "10_for_all_products"
        And I name it "$10.00 for all products!"
        And I add the "Order fixed discount" action configured with amount of "$10.00" for "United States" channel
        And I add it
        Then I should be notified that it has been successfully created
        And the "$10.00 for all products!" promotion should appear in the registry

    @api @ui @mink:chromedriver
    Scenario: Adding a promotion with item percentage discount
        When I want to create a new promotion
        And I specify its code as "promotion_for_all_product_items"
        And I name it "-20% for all product items!"
        And I add the "Item percentage discount" action configured with a percentage value of "20%" for "United States" channel
        And I add it
        Then I should be notified that it has been successfully created
        And it should have "20.00%" of item percentage discount configured for "United States" channel
