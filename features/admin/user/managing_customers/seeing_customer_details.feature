@managing_customers
Feature: Seeing customer's details
    In order to see customer's details in the store
    As an Administrator
    I want to be able to show specific customer's page

    Background:
        Given I am logged in as an administrator
        And the store has customer "f.baggins@shire.me" with name "Frodo Baggins" and phone number "666777888" since "2011-01-10 21:00"

    @api @ui
    Scenario: Seeing customer's basic information
        When I view details of the customer "f.baggins@shire.me"
        Then their name should be "Frodo Baggins"
        And he should be registered since "2011-01-10 21:00:00"
        And their email should be "f.baggins@shire.me"
        And their phone number should be "666777888"

    @api @ui
    Scenario: Seeing customer's default address
        Given the store operates in "New Zealand"
        And their default address is "Hobbiton", "Bag End", "1", "New Zealand" for "Frodo Baggins"
        When I view details of the customer "f.baggins@shire.me"
        Then their default address should be "Frodo" "Baggins", "Bag End", "1" "Hobbiton", "New Zealand"

    @api @ui
    Scenario: Seeing information about no existing account for a given customer
        When I view details of the customer "f.baggins@shire.me"
        Then I should see information about no existing account for this customer

    @api @ui
    Scenario: Seeing information about subscription to the newsletter
        Given the customer subscribed to the newsletter
        When I view details of the customer "f.baggins@shire.me"
        Then I should see that this customer is subscribed to the newsletter

    @api @ui
    Scenario: Seeing information about customer groups
        Given the store has a customer group Retail
        And the customer belongs to group "Retail"
        When I view details of the customer "f.baggins@shire.me"
        Then this customer should have "Retail" as their group

    @api @ui
    Scenario: Not Seeing information about email verification for not registered customer
        When I view details of the customer "f.baggins@shire.me"
        Then I should not see information about email verification

    @api @ui
    Scenario: Seeing information about verified email for registered customer
        Given there is a customer "Legolas Sindar" identified by an email "legolas@woodland.rm" and a password "takingTheHobbitsToIsengard"
        And this customer verified their email
        When I view details of the customer "legolas@woodland.rm"
        Then I should see that this customer has verified the email
