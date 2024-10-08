@managing_payment_methods
Feature: Adding a new payment method
    In order to pay for orders in different ways
    As an Administrator
    I want to add a new payment method to the registry

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @api @ui
    Scenario: Adding a new payment method
        When I want to create a new offline payment method
        And I name it "Offline" in "English (United States)"
        And I specify its code as "OFF"
        And I add it
        Then I should be notified that it has been successfully created
        And the payment method "Offline" should appear in the registry

    @api @ui
    Scenario: Adding a new payment method with description
        When I want to create a new offline payment method
        And I name it "Offline" in "English (United States)"
        And I specify its code as "OFF"
        And I describe it as "Payment method Offline" in "English (United States)"
        And I add it
        Then I should be notified that it has been successfully created
        And the payment method "Offline" should appear in the registry

    @api @ui
    Scenario: Adding a new payment method with instructions
        When I want to create a new offline payment method
        And I name it "Offline" in "English (United States)"
        And I specify its code as "OFF"
        And I set its instruction as "Bank account: 0000 1111 2222 3333" in "English (United States)"
        And I add it
        Then I should be notified that it has been successfully created
        And the payment method "Offline" should appear in the registry
        And the payment method "Offline" should have instructions "Bank account: 0000 1111 2222 3333" in "English (United States)"

    @api @ui
    Scenario: Adding a new payment method for channel
        When I want to create a new offline payment method
        And I name it "Offline" in "English (United States)"
        And I specify its code as "OFF"
        And make it available in channel "United States"
        And I add it
        Then I should be notified that it has been successfully created
        And the payment method "Offline" should appear in the registry
        And the payment method "Offline" should be available in channel "United States"
