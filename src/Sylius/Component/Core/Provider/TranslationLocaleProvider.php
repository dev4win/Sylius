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

namespace Sylius\Component\Core\Provider;

use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Locale\Provider\LocaleCollectionProviderInterface;
use Sylius\Resource\Translation\Provider\TranslationLocaleProviderInterface;

final class TranslationLocaleProvider implements TranslationLocaleProviderInterface
{
    public function __construct(
        private LocaleCollectionProviderInterface $localeRepository,
        private string $defaultLocaleCode,
    ) {
    }

    public function getDefinedLocalesCodes(): array
    {
        $locales = $this->localeRepository->getAll();

        return array_map(
            function (LocaleInterface $locale) {
                return (string) $locale->getCode();
            },
            $locales,
        );
    }

    public function getDefaultLocaleCode(): string
    {
        return $this->defaultLocaleCode;
    }
}
