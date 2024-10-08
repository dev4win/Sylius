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

namespace Sylius\Behat\Page\Shop\Checkout;

use Sylius\Behat\Page\Shop\PageInterface as ShopPageInterface;
use Sylius\Component\Core\Model\AddressInterface;

interface AddressPageInterface extends ShopPageInterface
{
    public function chooseDifferentShippingAddress(): void;

    public function chooseDifferentBillingAddress(): void;

    public function checkInvalidCredentialsValidation(): bool;

    public function checkValidationMessageFor(string $element, string $message): bool;

    public function checkFormValidationMessage(string $message): bool;

    public function specifyShippingAddress(AddressInterface $shippingAddress): void;

    public function selectShippingAddressProvince(string $province): void;

    public function specifyBillingAddress(AddressInterface $billingAddress): void;

    public function selectBillingAddressProvince(string $province): void;

    public function specifyEmail(?string $email): void;

    public function specifyBillingAddressFullName(string $fullName): void;

    public function canSignIn(): bool;

    public function signIn(): void;

    public function specifyPassword(string $password): void;

    public function getItemSubtotal(string $itemName): string;

    public function getShippingAddressCountry(): string;

    public function getBillingAddressCountry(): string;

    public function nextStep(): void;

    public function backToStore(): void;

    public function specifyBillingAddressProvince(string $provinceName): void;

    public function specifyShippingAddressProvince(string $provinceName): void;

    public function hasShippingAddressInput(): bool;

    public function hasBillingAddressInput(): bool;

    public function hasEmailInput(): bool;

    public function selectShippingAddressFromAddressBook(AddressInterface $address): void;

    public function selectBillingAddressFromAddressBook(AddressInterface $address): void;

    public function getPreFilledShippingAddress(): AddressInterface;

    public function getPreFilledBillingAddress(): AddressInterface;

    /** @return string[] */
    public function getAvailableShippingCountries(): array;

    /** @return string[] */
    public function getAvailableBillingCountries(): array;

    public function isDifferentShippingAddressChecked(): bool;

    public function isShippingAddressVisible(): bool;

    public function waitForFormToStopLoading(): void;
}
