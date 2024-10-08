@viewing_products
Feature: Viewing product's attributes in different locales
    In order to see product's specification in different than default locale
    As a Visitor
    I want to be able to see product's attributes in chosen locale

    Background:
        Given the store operates on a channel named "Web"
        And that channel allows to shop using "English (United States)" and "Polish (Poland)" locales
        And it uses the "English (United States)" locale by default
        And the store has a product "T-Shirt banana"
        And this product has a text attribute "T-Shirt material" with value "Banana skin" in "English (United States)" locale
        And this product has a text attribute "T-Shirt material" with value "Skórka banana" in "Polish (Poland)" locale
        And this product has a textarea attribute "T-Shirt details" with value "Banana is a very good material." in "English (United States)" locale

    @api @ui
    Scenario: Viewing a detailed page with product's text attribute after locale change
        When I view product "T-Shirt banana" in the "Polish (Poland)" locale
        Then I should see the product attribute "T-Shirt material" with value "Skórka banana"
        And I should also see the product attribute "T-Shirt details" with value "Banana is a very good material."
