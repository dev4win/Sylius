@customer_account
Feature: Viewing orders on my account page
    In order to follow my orders
    As a Customer
    I want to be able to track my placed orders

    Background:
        Given the store operates on a single channel in "United States"
        And the store has "Angel T-Shirt" and "Green Arrow" products
        And the store ships everywhere for Free
        And the store allows paying with "Cash on Delivery"
        And there is another customer "oliver@teamarrow.com" that placed an order "#00000999"
        And the customer bought a single "Green Arrow"
        And the customer "Oliver Queen" addressed it to "Seaside Fwy", "90802" "Los Angeles" in the "United States" with identical billing address
        And the customer chose "Free" shipping method with "Cash on Delivery" payment

    @api @ui
    Scenario: Viewing orders
        Given I am a logged in customer
        And I placed an order "#00000666"
        And I bought a single "Angel T-Shirt"
        And I addressed it to "Lucifer Morningstar", "Seaside Fwy", "90802" "Los Angeles" in the "United States" with identical billing address
        And I chose "Free" shipping method with "Cash on Delivery" payment
        When I browse my orders
        Then I should see a single order in the list
        And this order should have "#00000666" number

    @api @ui
    Scenario: Unauthenticated user cannot view orders
        When I try to browse my orders
        Then I should be denied an access to order list
