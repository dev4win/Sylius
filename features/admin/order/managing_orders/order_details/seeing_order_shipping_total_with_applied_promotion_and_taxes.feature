@managing_orders
Feature: Seeing shipping total with applied promotion and taxes
    In order to get to know the cost of shipping
    As an Administrator
    I want to be able to see shipping total

    Background:
        Given the store operates on a single channel in "United States"
        And the store has "VAT" tax rate of 23% for "Hogwart stuff" within the "US" zone
        And the store has "Shipping VAT" tax rate of 23% for "Shipping Services" within the "US" zone
        And the store has a product "Gryffindor scarf" priced at "$100.00"
        And it belongs to "Hogwart stuff" tax category
        And the store has "Owl post" shipping method with "$10.00" fee within the "US" zone
        And shipping method "Owl post" belongs to "Shipping Services" tax category
        And there is a promotion "50% shipping discount"
        And it gives "50%" discount on shipping to every order
        And the store allows paying Offline
        And there is a customer "fleur@delacour.com" that placed an order "#00000777"
        And the customer bought a single "Gryffindor scarf"
        And I am logged in as an administrator

    @api @ui
    Scenario: Seeing taxes of order items and shipping with applied promotion
        Given the customer chose "Owl post" shipping method to "United States" with "Offline" payment
        When I view the summary of the order "#00000777"
        Then the order's items total should be "$123.00"
        And there should be a shipping charge "$10.00" for "Owl post" method
        And there should be a shipping tax "$1.15" for "Owl post" method
        And the order's shipping total should be "$6.15"
        And the order's tax total should be "$24.15"
        And the order's total should be "$129.15"

    @api @ui
    Scenario: Seeing taxes of order items and multiple shipments with applied promotion
        Given the store has "Pigeon post" shipping method with "$16.00" fee within the "US" zone
        And shipping method "Pigeon post" belongs to "Shipping Services" tax category
        And the customer chose "Owl post" shipping method to "United States"
        And the customer bought another "Gryffindor scarf" with separate "Pigeon post" shipment
        And the customer chose "Offline" payment
        When I view the summary of the order "#00000777"
        Then the order's items total should be "$246.00"
        And there should be a shipping charge "$10.00" for "Owl post" method
        And there should be a shipping charge "$16.00" for "Pigeon post" method
        And there should be a shipping tax "$1.15" for "Owl post" method
        And there should be a shipping tax "$1.84" for "Pigeon post" method
        And the order's shipping total should be "$15.99"
        And the order's tax total should be "$48.99"
        And the order's total should be "$261.99"
