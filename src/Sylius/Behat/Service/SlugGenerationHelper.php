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

namespace Sylius\Behat\Service;

use Behat\Mink\Element\NodeElement;
use Behat\Mink\Session;

abstract class SlugGenerationHelper
{
    public static function waitForSlugGeneration(Session $session, NodeElement $element): void
    {
        JQueryHelper::waitForAsynchronousActionsToFinish($session);

        static::isElementReadonly($session, $element);

        JQueryHelper::waitForAsynchronousActionsToFinish($session);
    }

    private static function isElementReadonly(Session $session, NodeElement $element): bool
    {
        return $session->wait(1000, sprintf(
            'undefined != $(document.evaluate("%s", document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue).attr("readonly")',
            str_replace('"', '\"', $element->getXpath()),
        ));
    }
}
