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

namespace Sylius\Bundle\CurrencyBundle\Twig;

use Symfony\Component\Intl\Currencies;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class CurrencyExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('sylius_currency_symbol', [$this, 'convertCurrencyCodeToSymbol']),
        ];
    }

    public function convertCurrencyCodeToSymbol(string $code): string
    {
        return Currencies::getSymbol($code);
    }
}
