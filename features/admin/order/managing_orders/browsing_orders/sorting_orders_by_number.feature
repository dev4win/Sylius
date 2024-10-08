@managing_orders
Feature: Sorting orders by their number
    In order to faster find new orders
    As an Administrator
    I want to be able to sort orders by number

    Background:
        Given the store operates on a single channel in "United States"
        And the store has a product "Green Arrow"
        And the store ships everywhere for Free
        And the store allows paying Offline
        And there is a customer "oliver@teamarrow.com" that placed an order
        And the customer bought a single "Green Arrow"
        And the customer chose "Free" shipping method to "United States" with "Offline" payment
        And there is another customer "barry@teamflash.com" that placed an order
        And the customer bought a single "Green Arrow"
        And the customer chose "Free" shipping method to "United States" with "Offline" payment
        And there is another customer "bob@teamtick.com" that placed an order
        And the customer bought a single "Green Arrow"
        And the customer chose "Free" shipping method to "United States" with "Offline" payment
        And I am logged in as an administrator

    @api @ui
    Scenario: Orders are sorted by descending numbers by default
        When I browse orders
        Then I should see an order with "#000000001" number
        But the first order should have number "#000000003"

    @api @ui
    Scenario: Changing the number sorting order
        Given I am browsing orders
        When I switch the way orders are sorted by number
        Then I should see an order with "#000000003" number
        But the first order should have number "#000000001"
