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

namespace Sylius\Bundle\ApiBundle\Command;

use Sylius\Bundle\ApiBundle\Attribute\OrderTokenValueAware;
use Sylius\Bundle\CoreBundle\Command\ResendOrderConfirmationEmail as BaseResendOrderConfirmationEmail;

#[OrderTokenValueAware]
class ResendOrderConfirmationEmail extends BaseResendOrderConfirmationEmail
{
}
