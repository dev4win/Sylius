@managing_currencies
Feature: Browsing currencies
    In order to see all currencies in the store
    As an Administrator
    I want to browse currencies

    Background:
        Given the store has currency "Euro", "British Pound"
        And I am logged in as an administrator

    @api @ui
    Scenario: Browsing currencies in store
        When I want to browse currencies of the store
        Then I should see 2 currencies on the list
        And I should see the currency "British Pound" on the list
