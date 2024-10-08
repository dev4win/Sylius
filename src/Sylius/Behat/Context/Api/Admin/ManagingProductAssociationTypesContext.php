<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Behat\Context\Api\Admin;

use Behat\Behat\Context\Context;
use Sylius\Behat\Client\ApiClientInterface;
use Sylius\Behat\Client\ResponseCheckerInterface;
use Sylius\Behat\Context\Api\Resources;
use Sylius\Component\Product\Model\ProductAssociationTypeInterface;
use Webmozart\Assert\Assert;

final readonly class ManagingProductAssociationTypesContext implements Context
{
    public const SORT_TYPES = ['ascending' => 'asc', 'descending' => 'desc'];

    public function __construct(
        private ApiClientInterface $client,
        private ResponseCheckerInterface $responseChecker,
    ) {
    }

    /**
     * @When I want to create a new product association type
     */
    public function iWantToCreateANewProductAssociationType(): void
    {
        $this->client->buildCreateRequest(Resources::PRODUCT_ASSOCIATION_TYPES);
    }

    /**
     * @When I specify its code as :productAssociationTypeCode
     */
    public function iSpecifyItsCodeAs(string $productAssociationTypeCode): void
    {
        $this->client->addRequestData('code', $productAssociationTypeCode);
    }

    /**
     * @When I name it :productAssociationTypeName in :localeCode
     * @When I do not name it
     */
    public function iNameItIn(?string $productAssociationTypeName = null, string $localeCode = 'en_US'): void
    {
        $this->client->updateRequestData([
            'translations' => [
                 $localeCode => [
                      'name' => $productAssociationTypeName,
                 ],
            ],
        ]);
    }

    /**
     * @When I (try to) add it
     */
    public function iAddIt(): void
    {
        $this->client->create();
    }

    /**
     * @When I remove its name from :localeCode translation
     */
    public function iRemoveItsNameFromTranslation(string $localeCode): void
    {
        $this->client->updateRequestData([
            'translations' => [
                $localeCode => [
                    'name' => null,
                ],
            ],
        ]);
    }

    /**
     * @When I sort the product associations :sortType by code
     */
    public function iSortProductAssociationsByCode(string $sortType = 'ascending'): void
    {
        $this->client->sort(['code' => self::SORT_TYPES[$sortType]]);
    }

    /**
     * @When I am browsing product association types
     * @When I want to browse product association types
     */
    public function iBrowseProductAssociationTypes(): void
    {
        $this->client->index(Resources::PRODUCT_ASSOCIATION_TYPES);
    }

    /**
     * @When I delete the :productAssociationType product association type
     */
    public function iDeleteTheProductAssociationType(ProductAssociationTypeInterface $productAssociationType): void
    {
        $this->client->delete(Resources::PRODUCT_ASSOCIATION_TYPES, $productAssociationType->getCode());
    }

    /**
     * @When I want to modify the :productAssociationType product association type
     */
    public function iWantToModifyTheProductAssociationType(ProductAssociationTypeInterface $productAssociationType): void
    {
        $this->client->buildUpdateRequest(Resources::PRODUCT_ASSOCIATION_TYPES, $productAssociationType->getCode());
    }

    /**
     * @When I rename it to :name in :localeCode
     */
    public function iRenameItToIn(string $name, string $localeCode): void
    {
        $this->client->updateRequestData(['translations' => [$localeCode => ['name' => $name]]]);
    }

    /**
     * @When I filter product association types with code containing :value
     */
    public function iFilterProductAssociationTypesWithCodeContaining(string $value): void
    {
        $this->client->addFilter('code', $value);
        $this->client->filter();
    }

    /**
     * @When I filter product association types with name containing :value
     */
    public function iFilterProductAssociationTypesWithNameContaining(string $value): void
    {
        $this->client->addFilter('translations.name', $value);
        $this->client->filter();
    }

    /**
     * @When I do not specify its code
     */
    public function iDoNotSpecifyItsCode(): void
    {
        // Intentionally left blank
    }

    /**
     * @Then I should be notified that it has been successfully created
     */
    public function iShouldBeNotifiedThatItHasBeenSuccessfullyCreated(): void
    {
        Assert::true(
            $this->responseChecker->isCreationSuccessful($this->client->getLastResponse()),
            'Product association type could not be created',
        );
    }

    /**
     * @Then the product association type :name should appear in the store
     */
    public function theProductAssociationTypeShouldAppearInTheStore(string $name): void
    {
        Assert::true(
            $this->responseChecker->hasItemWithValue($this->client->index(Resources::PRODUCT_ASSOCIATION_TYPES), 'name', $name),
            sprintf('There is no product association type with name "%s"', $name),
        );
    }

    /**
     * @Then I should see :count product association types in the list
     * @Then I should see a single product association type in the list
     */
    public function iShouldSeeProductAssociationTypesInTheList(int $count = 1): void
    {
        Assert::same($this->responseChecker->countCollectionItems($this->client->getLastResponse()), $count);
    }

    /**
     * @Then I should see the product association type :name in the list
     * @Then this product association type should still be named :name
     */
    public function iShouldSeeTheProductAssociationTypeInTheList(string $name): void
    {
        Assert::true(
            $this->responseChecker->hasItemWithValue($this->client->index(Resources::PRODUCT_ASSOCIATION_TYPES), 'name', $name),
            sprintf('There is no product association type with name "%s"', $name),
        );
    }

    /**
     * @Then /^I should be notified that it has been successfully deleted$/
     */
    public function iShouldBeNotifiedThatItHasBeenSuccessfullyDeleted(): void
    {
        Assert::true(
            $this->responseChecker->isDeletionSuccessful(
                $this->client->getLastResponse(),
            ),
            'Product association type could not be deleted',
        );
    }

    /**
     * @Then /^(this product association type) should no longer exist in the registry$/
     */
    public function thisProductAssociationTypeShouldNoLongerExistInTheRegistry(ProductAssociationTypeInterface $productAssociationType): void
    {
        Assert::false(
            $this->responseChecker->hasItemWithValue($this->client->index(Resources::PRODUCT_ASSOCIATION_TYPES), 'code', $productAssociationType->getCode()),
            sprintf('Product association type with code %s exist', $productAssociationType->getCode()),
        );
    }

    /**
     * @Then /^(this product association type) name should be "([^"]+)"$/
     */
    public function thisProductAssociationTypeNameShouldBe(ProductAssociationTypeInterface $productAssociationType, string $name): void
    {
        Assert::true(
            $this->responseChecker->hasValue($this->client->show(Resources::PRODUCT_ASSOCIATION_TYPES, $productAssociationType->getCode()), 'name', $name),
            sprintf('Product association type name is not %s', $name),
        );
    }

    /**
     * @Then I should not be able to edit its code
     */
    public function iShouldNotBeAbleToEditItsCode(): void
    {
        $this->client->addRequestData('code', 'NEW_CODE');

        Assert::false(
            $this->responseChecker->hasValue($this->client->update(), 'code', 'NEW_CODE'),
            'The shipping category code should not be changed to "NEW_CODE", but it is',
        );
    }

    /**
     * @Then I should see only one product association type in the list
     */
    public function iShouldSeeOnlyOneProductAssociationTypeInTheList(): void
    {
        Assert::count($this->responseChecker->getCollection($this->client->getLastResponse()), 1);
    }

    /**
     * @Then I should be notified that product association type with this code already exists
     */
    public function iShouldBeNotifiedThatProductAssociationTypeWithThisCodeAlreadyExists(): void
    {
        Assert::contains(
            $this->responseChecker->getError($this->client->getLastResponse()),
            'The association type with given code already exists.',
        );
    }

    /**
     * @Then there should still be only one product association type with a code :code
     */
    public function thereShouldStillBeOnlyOneProductAssociationTypeWithACode(string $code): void
    {
        Assert::count(
            $this->responseChecker->getCollectionItemsWithValue($this->client->index(Resources::PRODUCT_ASSOCIATION_TYPES), 'code', $code),
            1,
            sprintf('More then one Product association type have code %s.', $code),
        );
    }

    /**
     * @Then I should be notified that :type is required
     */
    public function iShouldBeNotifiedThatCodeIsRequired(string $type): void
    {
        Assert::contains(
            $this->responseChecker->getError($this->client->getLastResponse()),
            sprintf('Please enter association type %s.', $type),
        );
    }

    /**
     * @Then the product association type with :type :value should not be added
     */
    public function theProductAssociationTypeWithNameShouldNotBeAdded(string $type, string $value): void
    {
        Assert::false(
            $this->responseChecker->hasItemWithValue($this->client->index(Resources::PRODUCT_ASSOCIATION_TYPES), $type, $value),
            sprintf('Product association type with %s %s exist', $type, $value),
        );
    }

    /**
     * @Then the first product association on the list should have code :value
     */
    public function theFirstProductAssociationOnTheListShouldHave(string $value): void
    {
        $productAssociations = $this->responseChecker->getCollection($this->client->getLastResponse());

        Assert::same(reset($productAssociations)['code'], $value);
    }

    /**
     * @Then the last product association on the list should have code :value
     */
    public function theLastProductAssociationOnTheListShouldHave(string $value): void
    {
        $productAssociations = $this->responseChecker->getCollection($this->client->getLastResponse());

        Assert::same(end($productAssociations)['code'], $value);
    }
}
