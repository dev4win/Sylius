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

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Behaviour\ChecksCodeImmutability;
use Sylius\Behat\Page\Admin\Crud\UpdatePage as BaseUpdatePage;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Currency\Model\CurrencyInterface;

class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
    use ChecksCodeImmutability;

    protected function getCodeElement(): NodeElement
    {
        return $this->getElement('code');
    }

    public function specifyPrice(int $price, ?ChannelInterface $channel = null): void
    {
        if ($channel === null) {
            $this->getDocument()->fillField('Price', $price);

            return;
        }

        $this->getElement('price', ['%channelCode%' => $channel->getCode()])->setValue($price);
    }

    public function specifyOriginalPrice(?int $originalPrice, ?ChannelInterface $channel = null): void
    {
        if ($channel === null) {
            $this->getDocument()->fillField('Original price', $originalPrice);

            return;
        }

        $this->getElement('original_price', ['%channelCode%' => $channel->getCode()])->setValue($originalPrice);
    }

    public function disableTracking(): void
    {
        $this->getElement('tracked')->uncheck();
    }

    public function enableTracking(): void
    {
        $this->getElement('tracked')->check();
    }

    public function isTracked(): bool
    {
        return $this->getElement('tracked')->isChecked();
    }

    public function getPricingConfigurationForChannelAndCurrencyCalculator(ChannelInterface $channel, CurrencyInterface $currency): string
    {
        $priceElement = $this->getElement('pricing_configuration')->find('css', sprintf('label:contains("%s %s")', $channel->getCode(), $currency->getCode()))->getParent();

        return $priceElement->find('css', 'input')->getValue();
    }

    public function getPriceForChannel(ChannelInterface $channel): string
    {
        return $this->getElement('price', ['%channelCode%' => $channel->getCode()])->getValue();
    }

    public function getMinimumPriceForChannel(ChannelInterface $channel): string
    {
        return $this->getElement('minimum_price', ['%channelCode%' => $channel->getCode()])->getValue();
    }

    public function getOriginalPriceForChannel(ChannelInterface $channel): string
    {
        return $this->getElement('original_price', ['%channelCode%' => $channel->getCode()])->getValue();
    }

    public function getNameInLanguage(string $language): string
    {
        return $this->getElement('name', ['%language%' => $language])->getValue();
    }

    public function specifyCurrentStock(int $amount): void
    {
        $this->getElement('on_hand')->setValue($amount);
    }

    public function selectOption(string $optionName, string $optionValue): void
    {
        $this->getElement('option_values', ['%optionName%' => $optionName])->selectOption($optionValue);
    }

    public function isShowInShopButtonDisabled(): bool
    {
        return $this->getElement('view_in_store')->hasClass('disabled');
    }

    public function showProductInChannel(ChannelInterface $channel): void
    {
        $this->getElement('view_in_store_in_channel', ['%channel_code%' => $channel->getCode()])->click();
    }

    public function showProductInSingleChannel(): void
    {
        $this->getElement('view_in_store')->click();
    }

    public function isSelectedOptionValueOnPage(string $optionName, string $valueName): bool
    {
        return $this->getDocument()->find('css', sprintf('option:contains("%s")', $valueName))->isSelected();
    }

    public function isShippingRequired(): bool
    {
        return $this->getElement('shipping_required')->isChecked();
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'code' => '#sylius_admin_product_variant_code',
            'enabled' => '#sylius_admin_product_variant_enabled',
            'minimum_price' => '#sylius_admin_product_variant_channelPricings_%channelCode%_minimumPrice',
            'name' => '#sylius_admin_product_variant_translations_%language%_name',
            'on_hand' => '#sylius_admin_product_variant_onHand',
            'option_values' => '#sylius_admin_product_variant_optionValues_%optionName%',
            'original_price' => '#sylius_admin_product_variant_channelPricings_%channelCode%_originalPrice',
            'price' => '#sylius_admin_product_variant_channelPricings_%channelCode%_price',
            'pricing_configuration' => '#sylius_calculator_container',
            'shipping_required' => '#sylius_admin_product_variant_shippingRequired',
            'show_product_single_button' => 'a:contains("Show product in shop page")',
            'tracked' => '#sylius_admin_product_variant_tracked',
            'view_in_store' => '[data-test-view-in-store]',
            'view_in_store_in_channel' => '[data-test-view-in-store] [data-test-channel-code="%channel_code%"]',
        ]);
    }

    public function disable(): void
    {
        $this->getElement('enabled')->uncheck();
    }

    public function isEnabled(): bool
    {
        return $this->getElement('enabled')->isChecked();
    }

    public function enable(): void
    {
        $this->getElement('enabled')->check();
    }
}
