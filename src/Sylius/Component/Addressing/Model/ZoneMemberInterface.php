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

namespace Sylius\Component\Addressing\Model;

use Sylius\Resource\Model\CodeAwareInterface;
use Sylius\Resource\Model\ResourceInterface;

interface ZoneMemberInterface extends ResourceInterface, CodeAwareInterface
{
    public function getBelongsTo(): ?ZoneInterface;

    public function setBelongsTo(?ZoneInterface $belongsTo): void;
}
