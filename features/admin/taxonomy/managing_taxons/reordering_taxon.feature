@managing_taxons
Feature: Reordering taxons
    In order to see all ordered taxons in the store
    As an Administrator
    I want to browse ordered taxons

    Background:
        Given the store classifies its products as "T-Shirts", "Watches", "Belts" and "Wallets"
        And I am logged in as an administrator

    @no-api @ui @mink:chromedriver
    Scenario: Moving up the taxon on list
        When I want to see all taxons in store
        And I move up "Watches" taxon
        Then I should see 4 taxons on the list
        And I should see the taxon named "T-Shirts" in the list
        But the first taxon on the list should be "Watches"

    @no-api @ui @mink:chromedriver
    Scenario: Moving down the taxon on list
        When I want to see all taxons in store
        And I move down "T-Shirts" taxon
        Then I should see 4 taxons on the list
        And I should see the taxon named "Watches" in the list
        But the first taxon on the list should be "Watches"

    @no-api @ui @mink:chromedriver
    Scenario: Moving up the first taxon on list
        When I want to see all taxons in store
        And I move up "T-Shirts" taxon
        Then I should see 4 taxons on the list
        And the first taxon on the list should be "T-Shirts"

    @no-api @ui @mink:chromedriver
    Scenario: Moving down the last taxon on list
        When I want to see all taxons in store
        And I move down "Wallets" taxon
        Then I should see 4 taxons on the list
        And the last taxon on the list should be "Wallets"

    @no-api @ui @mink:chromedriver
    Scenario: Changing order of the taxon on list
        When I want to see all taxons in store
        And I move down "T-Shirts" taxon
        And I move down "Belts" taxon
        And I move up "Wallets" taxon
        Then I should see 4 taxons on the list
        And the order of taxons should be "Watches", "Wallets", "T-Shirts" and "Belts"
