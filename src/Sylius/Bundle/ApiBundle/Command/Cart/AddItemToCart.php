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

namespace Sylius\Bundle\ApiBundle\Command\Cart;

use Sylius\Bundle\ApiBundle\Attribute\OrderTokenValueAware;
use Sylius\Bundle\ApiBundle\Command\IriToIdentifierConversionAwareInterface;

#[OrderTokenValueAware]
class AddItemToCart implements IriToIdentifierConversionAwareInterface
{
    public function __construct(
        public readonly string $orderTokenValue,
        public readonly string $productVariantCode,
        public readonly int $quantity,
    ) {
    }
}
