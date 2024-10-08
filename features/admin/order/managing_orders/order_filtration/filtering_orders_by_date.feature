@managing_orders
Feature: Filtering orders
    In order to filter orders in specific period of time
    As an Administrator
    I want to be able to filter orders on the list

    Background:
        Given the store operates on a single channel in "United States"
        And the store has customer "Mike Ross" with email "ross@teammike.com"
        And this customer has placed an order "#00000001" at "2016-12-04 08:00"
        And this customer has also placed an order "#00000002" at "2016-12-05 09:00"
        And this customer has also placed an order "#00000003" at "2016-12-06 10:00"
        And I am logged in as an administrator

    @api @ui
    Scenario: Filtering orders by date from
        When I browse orders
        And I specify filter date from as "2016-12-05 08:30"
        And I filter
        Then I should see 2 orders in the list
        And I should see an order with "#00000002" number
        And I should see an order with "#00000003" number
        But I should not see an order with "#00000001" number

    @api @ui
    Scenario: Filtering orders by date to
        When I browse orders
        And I specify filter date to as "2016-12-05 09:30"
        And I filter
        Then I should see 2 orders in the list
        And I should see an order with "#00000001" number
        And I should see an order with "#00000002" number
        But I should not see an order with "#00000003" number

    @api @ui
    Scenario: Filtering orders by date from to
        When I browse orders
        And I specify filter date from as "2016-12-05 08:30"
        And I specify filter date to as "2016-12-05 09:30"
        And I filter
        Then I should see a single order in the list
        And I should see an order with "#00000002" number
        But I should not see an order with "#00000001" number
        And I should not see an order with "#00000003" number

    @api @ui
    Scenario: Filtering orders by date from without time
        When I browse orders
        And I specify filter date from as "2016-12-05"
        And I specify filter date to as "2016-12-07"
        And I filter
        Then I should see 2 orders in the list
        And I should see an order with "#00000002" number
        And I should see an order with "#00000003" number
        But I should not see an order with "#00000001" number

    @api @ui
    Scenario: Filtering orders placed at midnight or just before midnight
        Given this customer has placed an order "#00000004" at "2016-12-10 00:00"
        And this customer has also placed an order "#00000005" at "2016-12-11 23:59"
        And this customer has also placed an order "#00000006" at "2016-12-12 00:00"
        When I browse orders
        And I specify filter date from as "2016-12-10"
        And I specify filter date to as "2016-12-11 23:59"
        And I filter
        Then I should see 2 orders in the list
        And I should see an order with "#00000004" number
        And I should see an order with "#00000005" number
        But I should not see an order with "#00000006" number
