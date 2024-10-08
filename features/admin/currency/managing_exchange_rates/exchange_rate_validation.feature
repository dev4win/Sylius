@managing_exchange_rates
Feature: Exchange rate validation
    In order to avoid making mistakes when managing exchange rates
    As an Administrator
    I want to be prevented from adding exchange rates without specifying required fields

    Background:
        Given the store has currency "US Dollar" and "British Pound"
        And I am logged in as an administrator

    @api @ui
    Scenario: Trying to add a new exchange rate without ratio
        When I want to add a new exchange rate
        And I choose "US Dollar" as the source currency
        And I choose "British Pound" as the target currency
        And I don't specify its ratio
        And I try to add it
        Then I should be notified that ratio is required
        And the exchange rate between "US Dollar" and "British Pound" should not be added

    @api @ui
    Scenario: Trying to add a new exchange rate with negative ratio
        When I want to add a new exchange rate
        And I choose "US Dollar" as the source currency
        And I choose "British Pound" as the target currency
        And I specify its ratio as -1.2
        And I try to add it
        Then I should be notified that the ratio must be greater than zero
        And the exchange rate between "US Dollar" and "British Pound" should not be added

    @api @ui
    Scenario: Trying to add a new exchange rate with an excessively high ratio
        When I want to add a new exchange rate
        And I choose "US Dollar" as the source currency
        And I choose "British Pound" as the target currency
        And I specify its ratio as 123450000
        And I try to add it
        Then I should be notified that the ratio must be less than 100000
        And the exchange rate between "US Dollar" and "British Pound" should not be added

    @api @ui
    Scenario: Trying to add a new exchange rate with an zero ratio
        When I want to add a new exchange rate
        And I choose "US Dollar" as the source currency
        And I choose "British Pound" as the target currency
        And I specify its ratio as 0
        And I try to add it
        Then I should be notified that the ratio must be greater than zero
        And the exchange rate between "US Dollar" and "British Pound" should not be added

    @api @ui
    Scenario: Trying to add a new exchange rate with same target currency as source
        When I want to add a new exchange rate
        And I specify its ratio as 1.23
        And I choose "US Dollar" as the source currency
        And I choose "US Dollar" as the target currency
        And I try to add it
        Then I should be notified that source and target currencies must differ
        And the exchange rate between "US Dollar" and "US Dollar" should not be added
