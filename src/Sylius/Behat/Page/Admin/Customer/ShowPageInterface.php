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

namespace Sylius\Behat\Page\Admin\Customer;

use FriendsOfBehat\PageObjectExtension\Page\PageInterface;

interface ShowPageInterface extends PageInterface
{
    public function deleteAccount(): void;

    public function getCustomerEmail(): string;

    public function getCustomerPhoneNumber(): string;

    public function getCustomerName(): string;

    public function getRegistrationDate(): \DateTimeInterface;

    public function getDefaultAddress(): string;

    public function hasAccount(): bool;

    public function isSubscribedToNewsletter(): bool;

    public function hasDefaultAddressProvinceName(string $provinceName): bool;

    public function hasVerifiedEmail(): bool;

    public function getGroupName(): string;

    public function hasEmailVerificationInformation(): bool;

    public function hasImpersonateButton(): bool;

    public function impersonate(): void;

    public function hasCustomerPlacedAnyOrders(): bool;

    public function getOrdersCountInChannel(string $channelCode): int;

    public function getOrdersTotalInChannel(string $channelCode): string;

    public function getAverageTotalInChannel(string $channelCode): string;

    public function getSuccessFlashMessage(): string;
}
