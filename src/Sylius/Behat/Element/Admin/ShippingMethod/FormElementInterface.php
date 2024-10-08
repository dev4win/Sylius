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

namespace Sylius\Behat\Element\Admin\ShippingMethod;

use Sylius\Behat\Element\Admin\Crud\FormElementInterface as BaseFormElementInterface;

interface FormElementInterface extends BaseFormElementInterface
{
    public function getCode(): string;

    public function setCode(string $code): void;

    public function isCodeDisabled(): bool;

    public function getName(string $localeCode = 'en_US');

    public function setName(string $name, string $localeCode = 'en_US'): void;

    public function getPosition(): int;

    public function setPosition(int $position): void;

    public function getDescription(string $localeCode = 'en_US'): string;

    public function setDescription(string $description, string $localeCode = 'en_US'): void;

    public function getZoneCode(): string;

    public function setZoneCode(string $code): void;

    public function enable(): void;

    public function disable(): void;

    public function checkChannel(string $channelCode): void;

    public function hasCheckedChannel(string $channelCode): bool;

    public function chooseCalculator(string $calculatorName): void;

    public function setCalculatorConfigurationAmountForChannel(string $channelCode, int $amount): void;

    public function addRule(string $type): void;

    public function fillLastRuleOption(string $fieldName, string $value): void;

    public function fillLastRuleOptionForChannel(string $channelCode, string $fieldName, string $value): void;

    public function getShippingChargesValidationErrorsCount(string $channelCode): int;

    public function setField(string $field, string $value): void;
}
