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

namespace Sylius\Bundle\CoreBundle\Doctrine\ORM;

use Sylius\Bundle\ProductBundle\Doctrine\ORM\ProductAssociationRepository as BaseProductAssociationRepository;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Repository\ProductAssociationRepositoryInterface;
use Sylius\Component\Product\Model\ProductAssociationInterface;

/**
 * @template T of ProductAssociationInterface
 *
 * @extends BaseProductAssociationRepository<T>
 *
 * @implements ProductAssociationRepositoryInterface<T>
 */
class ProductAssociationRepository extends BaseProductAssociationRepository implements ProductAssociationRepositoryInterface
{
    public function findWithProductsWithinChannel(int $associationId, ChannelInterface $channel): ProductAssociationInterface
    {
        $productAssociation = $this->createQueryBuilder('o')
            ->addSelect('associatedProduct')
            ->leftJoin('o.associatedProducts', 'associatedProduct', 'WITH', 'associatedProduct.enabled = true')
            ->innerJoin('associatedProduct.channels', 'channel', 'WITH', 'channel = :channel')
            ->andWhere('o.id = :associationId')
            ->setParameter('associationId', $associationId)
            ->setParameter('channel', $channel)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (null === $productAssociation) {
            $productAssociation = $this->find($associationId);
            $productAssociation->clearAssociatedProducts();
        }

        return $productAssociation;
    }
}
