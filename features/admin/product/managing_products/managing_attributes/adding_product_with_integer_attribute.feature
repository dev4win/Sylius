@managing_products
Feature: Adding a new product with an integer attribute
    In order to extend my merchandise with more complex products
    As an Administrator
    I want to add a new product with an integer attribute to the shop

    Background:
        Given the store operates on a single channel in "United States"
        And the store has an integer product attribute "Production year"
        And the store has a non-translatable integer product attribute "Weight"
        And I am logged in as an administrator

    @api @ui @mink:chromedriver
    Scenario: Adding an integer attribute to product
        When I want to create a new configurable product
        And I specify its code as "44_MAGNUM"
        And I name it "44 Magnum" in "English (United States)" locale
        And I set its slug to "44-magnum"
        And I add the "Production year" attribute to it
        And I set the "Production year" attribute value to 1955 in "English (United States)" locale
        And I add it
        Then I should be notified that it has been successfully created
        And the product "44 Magnum" should appear in the store
        And attribute "Production year" of product "44 Magnum" should be 1955

    @api @ui @mink:chromedriver
    Scenario: Adding an integer non-translatable attribute to product
        When I want to create a new configurable product
        And I specify its code as "44_MAGNUM"
        And I name it "44 Magnum" in "English (United States)" locale
        And I set its slug to "44-magnum"
        And I add the "Weight" attribute to it
        And I set its non-translatable "Weight" attribute to 10
        And I add it
        Then I should be notified that it has been successfully created
        And the product "44 Magnum" should appear in the store
        And non-translatable attribute "Weight" of product "44 Magnum" should be 10

    @api @no-ui
    Scenario: Trying to add an invalid integer attribute to product
        When I want to create a new configurable product
        And I specify its code as "44_MAGNUM"
        And I name it "44 Magnum" in "English (United States)" locale
        And I set the invalid string value of the non-translatable "Weight" attribute to "ten"
        And I try to add it
        Then I should be notified that the value of the "Weight" attribute has invalid type
        And product with code "44_MAGNUM" should not be added
