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

namespace Sylius\Behat\Element\Admin\ProductOption;

use Sylius\Behat\Element\Admin\Crud\FormElementInterface as BaseFormElementInterface;

interface FormElementInterface extends BaseFormElementInterface
{
    public function specifyCode(string $code): void;

    public function isCodeDisabled(): bool;

    public function setName(string $name, string $localeCode): void;

    public function addOptionValue(string $code, string $localeCode, string $value): void;

    public function hasOptionValue(string $optionValue, string $localeCode): bool;

    public function applyToAllOptionValues(string $code, string $localeCode): void;
}
