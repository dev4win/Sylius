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

namespace Sylius\Bundle\ProductBundle\Form\Type;

use Sylius\Bundle\ProductBundle\Form\EventSubscriber\BuildAttributesFormSubscriber;
use Sylius\Bundle\ProductBundle\Form\EventSubscriber\ProductOptionFieldSubscriber;
use Sylius\Bundle\ProductBundle\Form\EventSubscriber\SimpleProductSubscriber;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Sylius\Component\Attribute\Model\AttributeValueInterface;
use Sylius\Component\Product\Resolver\ProductVariantResolverInterface;
use Sylius\Resource\Factory\FactoryInterface;
use Sylius\Resource\Translation\Provider\TranslationLocaleProviderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class ProductType extends AbstractResourceType
{
    /**
     * @param array|string[] $validationGroups
     * @param FactoryInterface<AttributeValueInterface> $attributeValueFactory
     */
    public function __construct(
        string $dataClass,
        private string $productOptionClass,
        array $validationGroups,
        private ProductVariantResolverInterface $variantResolver,
        private FactoryInterface $attributeValueFactory,
        private TranslationLocaleProviderInterface $localeProvider,
    ) {
        parent::__construct($dataClass, $validationGroups);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addEventSubscriber(new ProductOptionFieldSubscriber($this->variantResolver, $this->productOptionClass))
            ->addEventSubscriber(new SimpleProductSubscriber())
            ->addEventSubscriber(new BuildAttributesFormSubscriber($this->attributeValueFactory, $this->localeProvider))
            ->addEventListener(FormEvents::PRE_SET_DATA, $this->addCodeField(...))
            ->add('enabled', CheckboxType::class, [
                'required' => false,
                'label' => 'sylius.form.product.enabled',
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'entry_type' => ProductTranslationType::class,
                'label' => 'sylius.form.product.translations',
            ])
            ->add('attributes', CollectionType::class, [
                'entry_type' => ProductAttributeValueType::class,
                'required' => false,
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
            ])
            ->add('associations', ProductAssociationsType::class, [
                'label' => false,
            ])
        ;
    }

    private function addCodeField(FormEvent $event): void
    {
        $product = $event->getData();

        if (null === $product) {
            return;
        }

        $event->getForm()->add('code', TextType::class, [
            'label' => 'sylius.ui.code',
            'disabled' => null !== $product->getId(),
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_product';
    }
}
