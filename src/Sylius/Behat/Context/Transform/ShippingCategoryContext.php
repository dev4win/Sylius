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

namespace Sylius\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Webmozart\Assert\Assert;

class ShippingCategoryContext implements Context
{
    public function __construct(private RepositoryInterface $shippingCategoryRepository)
    {
    }

    /**
     * @Transform /^"([^"]+)" shipping category/
     * @Transform /^shipping category "([^"]+)"/
     * @Transform /^shipping category with name "([^"]+)"$/
     * @Transform :shippingCategory
     */
    public function getShippingCategoryByName($shippingCategoryName)
    {
        $shippingCategories = $this->shippingCategoryRepository->findBy(['name' => $shippingCategoryName]);

        Assert::eq(
            count($shippingCategories),
            1,
            sprintf('%d shipping category has been found with name "%s".', count($shippingCategories), $shippingCategoryName),
        );

        return $shippingCategories[0];
    }
}
