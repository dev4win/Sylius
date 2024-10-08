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

namespace Sylius\Bundle\ApiBundle\Doctrine\ORM\QueryExtension\Shop\Order;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ApiBundle\SectionResolver\ShopApiSection;
use Sylius\Bundle\CoreBundle\SectionResolver\SectionProviderInterface;
use Sylius\Component\Core\Model\OrderInterface;

final readonly class StateBasedExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    /** @param array<string> $cartAllowedOperations */
    public function __construct(
        private SectionProviderInterface $sectionProvider,
        private array $cartAllowedOperations = [],
    ) {
    }

    /**
     * @param array<array-key, mixed> $context
     */
    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        ?Operation $operation = null,
        array $context = [],
    ): void {
        if (!is_a($resourceClass, OrderInterface::class, true)) {
            return;
        }

        if (!$this->sectionProvider->getSection() instanceof ShopApiSection) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $stateParameter = $queryNameGenerator->generateParameterName('state');

        $queryBuilder
            ->andWhere($queryBuilder->expr()->neq(sprintf('%s.state', $rootAlias), sprintf(':%s', $stateParameter)))
            ->setParameter($stateParameter, OrderInterface::STATE_CART)
        ;
    }

    /**
     * @param array<array-key, mixed> $identifiers
     * @param array<array-key, mixed> $context
     */
    public function applyToItem(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        array $identifiers,
        ?Operation $operation = null,
        array $context = [],
    ): void {
        if (!is_a($resourceClass, OrderInterface::class, true)) {
            return;
        }

        if (!$this->sectionProvider->getSection() instanceof ShopApiSection) {
            return;
        }

        if (in_array($operation->getName(), $this->cartAllowedOperations, true)) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $stateParameter = $queryNameGenerator->generateParameterName('state');

        $queryBuilder
            ->andWhere($queryBuilder->expr()->eq(sprintf('%s.state', $rootAlias), sprintf(':%s', $stateParameter)))
            ->setParameter($stateParameter, OrderInterface::STATE_CART)
        ;
    }
}
