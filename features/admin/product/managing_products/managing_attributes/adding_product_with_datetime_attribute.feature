@managing_products
Feature: Adding a new product with a datetime attribute
    In order to extend my merchandise with more complex products
    As an Administrator
    I want to add a new product with a datetime attribute to the shop

    Background:
        Given the store operates on a single channel in "United States"
        And the store has a non-translatable datetime product attribute "Manufactured" with format "Y-m-d"
        And I am logged in as an administrator

    @api
    Scenario: Adding a datetime attribute to a product
        When I want to create a new configurable product
        And I specify its code as "mug"
        And I name it "Mug" in "English (United States)" locale
        And I set its non-translatable "Manufactured" attribute to "2023-10-10 10:20:30"
        And I add it
        Then I should be notified that it has been successfully created
        And the product "Mug" should appear in the store
        And non-translatable attribute "Manufactured" of product "Mug" should be "2023-10-10 10:20:30"

    @api @no-ui
    Scenario: Trying to add an invalid datetime attribute to product
        When I want to create a new configurable product
        And I specify its code as "44_MAGNUM"
        And I name it "44 Magnum" in "English (United States)" locale
        And I set the invalid integer value of the non-translatable "Manufactured" attribute to 10
        And I try to add it
        Then I should be notified that the value of the "Manufactured" attribute has invalid type
        And product with code "44_MAGNUM" should not be added
