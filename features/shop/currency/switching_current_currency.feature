@currencies
Feature: Switching the current currency
    In order to see prices in my preferred currency
    As a Customer
    I want to be able to switch currencies

    Background:
        Given the store operates on a channel named "Web" in "EUR" currency
        And that channel allows to shop using "EUR" and "USD" currencies

    @api @ui
    Scenario: Showing the current currency
        When I browse that channel
        Then I should shop using the "EUR" currency

    @no-api @ui
    Scenario: Showing available currencies
        When I browse that channel
        Then I should be able to shop using the "USD" currency

    @api @ui
    Scenario: Showing available currencies
        When I browse currencies
        Then I should see "USD" and "EUR" in the list

    @no-api @ui
    Scenario: Switching the current currency
        When I browse that channel
        And I switch to the "USD" currency
        Then I should shop using the "USD" currency
        And I should be able to shop using the "EUR" currency
