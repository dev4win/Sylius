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

namespace Sylius\Behat\Page\Admin\ProductVariant;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;

interface GeneratePageInterface extends BaseCreatePageInterface
{
    public function generate(): void;

    public function specifyPrice(int $nth, int $price, string $channelCode): void;

    public function specifyCode(int $nth, string $code): void;

    public function removeVariant(int $nth): void;

    public function isGenerationPossible(): bool;

    public function isProductVariantRemovable(int $nth): bool;
}
