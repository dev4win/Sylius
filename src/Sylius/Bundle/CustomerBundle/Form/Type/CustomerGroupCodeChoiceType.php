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

namespace Sylius\Bundle\CustomerBundle\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\DataTransformer\ResourceToIdentifierTransformer;
use Sylius\Component\Customer\Model\CustomerGroupInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\ReversedTransformer;

final class CustomerGroupCodeChoiceType extends AbstractType
{
    /** @param RepositoryInterface<CustomerGroupInterface> $customerGroupRepository */
    public function __construct(private RepositoryInterface $customerGroupRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer(new ReversedTransformer(new ResourceToIdentifierTransformer($this->customerGroupRepository, 'code')));
    }

    public function getParent(): string
    {
        return CustomerGroupChoiceType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_customer_group_code_choice';
    }
}
