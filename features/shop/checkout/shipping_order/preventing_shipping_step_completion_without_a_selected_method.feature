@checkout
Feature: Preventing shipping step completion without a selected method
    In order to be prevent from finish shipping step without selected method
    As a Customer
    I want to be prevent from finish shipping step without selected method

    Background:
        Given I am a logged in customer

    @todo-api @ui @javascript
    Scenario: Preventing shipping step completion if there are no available shipping methods
        Given the store operates on a single channel in "United States"
        And the store has a product "PHP T-Shirt" priced at "$19.99"
        And I have product "PHP T-Shirt" in the cart
        When I specified the billing address as "Ankh Morpork", "Frost Alley", "90210", "United States" for "Jon Snow"
        Then I should be informed that my order cannot be shipped to this address
        And I should not be able to proceed checkout shipping step

    @todo-api @ui @javascript
    Scenario: Preventing shipping step completion if there are no available shipping methods for selected country
        Given the store operates on a channel named "Web"
        And the store has a product "PHP T-Shirt" priced at "$19.99"
        And the store operates in "United States"
        And the store operates in "France"
        And the store has a zone "Europe" with code "EU"
        And this zone has the "France" country member
        And the store has "DHL" shipping method with "$20.00" fee within the "EU" zone
        And I have product "PHP T-Shirt" in the cart
        When I specified the billing address as "Ankh Morpork", "Frost Alley", "90210", "United States" for "Jon Snow"
        Then I should be informed that my order cannot be shipped to this address
        And I should not be able to proceed checkout shipping step

    @todo-api @no-ui
    Scenario: Preventing shipping step completion if there are no available shipping methods for selected country
        Given the store operates on a channel named "Web"
        And the store has a product "PHP T-Shirt" priced at "$19.99"
        And the store operates in "United States"
        And the store operates in "France"
        And the store has a zone "Europe" with code "EU"
        And this zone has the "France" country member
        And the store has a zone "America" with code "AMR"
        And this zone has the "United States" country member
        And the store has "DHL" shipping method with "$20.00" fee within the "EU" zone
        And the store has "UPS" shipping method with "$20.00" fee within the "AMR" zone
        And I have product "PHP T-Shirt" in the cart
        When I specified the billing address as "Ankh Morpork", "Frost Alley", "90210", "United States" for "Jon Snow"
        And I do not select any shipping method
        And I try to complete the shipping step
        Then I should still be on the shipping step
        And I should be notified that the shipping method is required
