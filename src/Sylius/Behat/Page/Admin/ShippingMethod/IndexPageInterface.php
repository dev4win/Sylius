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

namespace Sylius\Behat\Page\Admin\ShippingMethod;

use Sylius\Behat\Page\Admin\Crud\IndexPageInterface as BaseIndexPageInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;

interface IndexPageInterface extends BaseIndexPageInterface
{
    public function chooseArchival(string $isArchival): void;

    public function isArchivalFilterEnabled(): bool;

    public function archiveShippingMethod(string $name): void;

    public function restoreShippingMethod(string $name): void;

    public function isShippingMethodEnabled(ShippingMethodInterface $shippingMethod): bool;

    public function isShippingMethodDisabled(ShippingMethodInterface $shippingMethod): bool;
}
