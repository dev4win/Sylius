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

namespace Sylius\Bundle\ShopBundle\Form\Type;

use Sylius\Bundle\CoreBundle\Form\Type\User\ShopUserRegistrationType as BaseShopUserRegistrationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

final class ShopUserRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'sylius.form.user.password.label', 'always_empty' => false],
                'second_options' => ['label' => 'sylius.form.user.password.confirmation', 'always_empty' => false],
                'invalid_message' => 'sylius.user.plainPassword.mismatch',
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_shop_shop_user_registration';
    }

    public function getParent(): string
    {
        return BaseShopUserRegistrationType::class;
    }
}
