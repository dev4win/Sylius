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

namespace Sylius\Component\Attribute\Repository;

use Sylius\Component\Attribute\Model\AttributeValueInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;

/**
 * @template T of AttributeValueInterface
 *
 * @extends RepositoryInterface<T>
 */
interface AttributeValueRepositoryInterface extends RepositoryInterface
{
}
