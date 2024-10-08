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

namespace Sylius\Bundle\ApiBundle\Doctrine\ORM\QueryExtension\Shop\Taxon;

use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ApiBundle\Context\UserContextInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;

final readonly class EnabledExtension implements QueryItemExtensionInterface
{
    public function __construct(private UserContextInterface $userContext)
    {
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
        if (!is_a($resourceClass, TaxonInterface::class, true)) {
            return;
        }

        $user = $this->userContext->getUser();
        if ($user !== null && in_array('ROLE_API_ACCESS', $user->getRoles(), true)) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $enabledParameter = $queryNameGenerator->generateParameterName('enabled');
        $childAlias = $queryNameGenerator->generateJoinAlias('child');

        $queryBuilder->addSelect($childAlias);
        $queryBuilder->leftJoin(sprintf('%s.children', $rootAlias), $childAlias, 'WITH', sprintf('%s.enabled = :%s', $childAlias, $enabledParameter));
        $queryBuilder->andWhere(sprintf('%s.enabled = :%s', $rootAlias, $enabledParameter));  // TODO: potentially remove from here and apply via a global enabled query extension
        $queryBuilder->setParameter($enabledParameter, true);
    }
}
