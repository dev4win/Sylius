@managing_tax_categories
Feature: Tax category validation
    In order to avoid making mistakes when managing a tax category
    As an Administrator
    I want to be prevented from adding it without specifying its code or name

    Background:
        Given I am logged in as an administrator

    @api @ui
    Scenario: Trying to add a new tax category without specifying its code
        When I want to create a new tax category
        And I name it "Food and Beverage"
        But I do not specify its code
        And I try to add it
        Then I should be notified that code is required
        And tax category with name "Food and Beverage" should not be added

    @api @ui
    Scenario: Trying to add a new tax category with a too long code
        When I want to create a new tax category
        And I name it "Food and Beverage"
        And I specify a too long code
        And I try to add it
        Then I should be notified that code is too long

    @api @ui
    Scenario: Trying to add a new tax category without specifying its name
        When I want to create a new tax category
        And I specify its code as "food_and_beverage"
        But I do not name it
        And I try to add it
        Then I should be notified that name is required
        And tax category with code "food_and_beverage" should not be added

    @api @ui
    Scenario: Trying to add a new tax category with a too long name
        When I want to create a new tax category
        And I name it "Food and Beverage"
        And I specify a too long name
        And I specify its code as "food_and_beverage"
        And I try to add it
        Then I should be notified that name is too long

    @api @ui
    Scenario: Trying to remove name from existing tax category
        Given the store has a tax category "Alcoholic Drinks" with a code "alcohol"
        When I want to modify this tax category
        And I remove its name
        And I try to save my changes
        Then I should be notified that name is required
        And this tax category should still be named "Alcoholic Drinks"
