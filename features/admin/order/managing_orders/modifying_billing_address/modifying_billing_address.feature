@modifying_placed_order_address
Feature: Modifying a customer billing address after an order has been placed
    In order to ship an order's bill to a correct place
    As an Administrator
    I want to be able to modify a customer's billing address after an order has been placed

    Background:
        Given the store operates on a single channel in the "United States" named "Web"
        And the store ships everywhere for Free
        And the store allows paying with "Cash on Delivery"
        And the store has a product "Suit" priced at "$400.00"
        And there is a customer "mike@ross.com" that placed an order "#00000001"
        And the customer bought a single "Suit"
        And the customer "Mike Ross" addressed it to "350 5th Ave", "10118" "New York" in the "United States" with identical billing address
        And the customer chose "Free" shipping method with "Cash on Delivery" payment
        And I am logged in as an administrator

    @api @ui
    Scenario: Modifying a customer's billing address
        When I view the summary of the order "#00000001"
        And I want to modify a customer's billing address of this order
        And I specify their new billing address as "Los Angeles", "Seaside Fwy", "90802", "United States" for "Lucifer Morningstar"
        And I save my changes
        Then I should be notified that it has been successfully edited
        And this order should have "Lucifer Morningstar", "Seaside Fwy", "90802", "Los Angeles", "United States" as its billing address

    @no-api @ui @mink:chromedriver
    Scenario: Being able to choose only provinces of the selected country
        Given the store also has country "Poland"
        And this country has the "Malopolska" province with "ML" code
        And this country has the "Slaskie" province with "SL" code
        When I view the summary of the order "#00000001"
        And I want to modify a customer's billing address of this order
        And I change the billing country to "Poland"
        Then I should be able to choose the "Malopolska" province for the billing address
        And I should be able to choose the "Slaskie" province for the billing address

    @api @ui
    Scenario: Modifying a customer's billing address when a product's price has been changed
        Given the product "Suit" changed its price to "$300.00"
        When I view the summary of the order "#00000001"
        And I want to modify a customer's billing address of this order
        And I specify their new billing address as "Los Angeles", "Seaside Fwy", "90802", "United States" for "Lucifer Morningstar"
        And I save my changes
        Then I should be notified that it has been successfully edited
        And this order should have "Lucifer Morningstar", "Seaside Fwy", "90802", "Los Angeles", "United States" as its billing address
        And the order's total should still be "$400.00"

    @api @ui
    Scenario: Modifying a customer's billing address when a channel has been disabled
        Given the channel "Web" has been disabled
        When I view the summary of the order "#00000001"
        And I want to modify a customer's billing address of this order
        And I specify their new billing address as "Los Angeles", "Seaside Fwy", "90802", "United States" for "Lucifer Morningstar"
        And I save my changes
        Then I should be notified that it has been successfully edited
        And this order should have "Lucifer Morningstar", "Seaside Fwy", "90802", "Los Angeles", "United States" as its billing address
        And the order's total should still be "$400.00"

    @api @ui
    Scenario: Modifying a customer's billing address when the currency has been disabled
        Given the currency "USD" has been disabled
        When I view the summary of the order "#00000001"
        And I want to modify a customer's billing address of this order
        And I specify their new billing address as "Los Angeles", "Seaside Fwy", "90802", "United States" for "Lucifer Morningstar"
        And I save my changes
        Then I should be notified that it has been successfully edited
        And this order should have "Lucifer Morningstar", "Seaside Fwy", "90802", "Los Angeles", "United States" as its billing address
        And the order's total should still be "$400.00"

    @api @ui
    Scenario: Modifying a customer's billing address when the product is out of stock
        Given the product "Suit" is out of stock
        When I view the summary of the order "#00000001"
        And I want to modify a customer's billing address of this order
        And I specify their new billing address as "Los Angeles", "Seaside Fwy", "90802", "United States" for "Lucifer Morningstar"
        And I save my changes
        Then I should be notified that it has been successfully edited
        And this order should have "Lucifer Morningstar", "Seaside Fwy", "90802", "Los Angeles", "United States" as its billing address
        And the order's total should still be "$400.00"
