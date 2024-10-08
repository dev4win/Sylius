@managing_product_attributes
Feature: Sorting listed product attributes by position
    In order to change the order by which product attributes are displayed
    As an Administrator
    I want to sort product attributes by their positions

    Background:
        Given the store has a text product attribute "T-Shirt brand" at position 1
        And the store has a checkbox product attribute "T-Shirt with cotton" at position 2
        And the store has a integer product attribute "Book pages" at position 0
        And I am logged in as an administrator

    @api @ui
    Scenario: Product attributes are sorted by position in ascending order by default
        When I want to see all product attributes in store
        Then I should see 3 product attributes in the list
        And the first product attribute on the list should have name "Book pages"
        And the last product attribute on the list should have name "T-Shirt with cotton"

    @api @ui
    Scenario: Product attribute added at no position gets put at the bottom of the list
        Given the store has also a text product attribute "Drive type"
        When I want to see all product attributes in store
        Then I should see 4 product attributes in the list
        And the last product attribute on the list should have name "Drive type"

    @api @ui
    Scenario: Product attribute added at position 0 is added as the first one
        Given the store has also a text product attribute "Drive type" at position 0
        When I want to see all product attributes in store
        Then I should see 4 product attributes in the list
        Then the first product attribute on the list should have name "Drive type"
