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

namespace Sylius\Bundle\CoreBundle\Form\Type\Taxon;

use Sylius\Bundle\CoreBundle\Form\DataTransformer\ProductTaxonToTaxonTransformer;
use Sylius\Bundle\ResourceBundle\Form\DataTransformer\RecursiveTransformer;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceAutocompleteChoiceType;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductTaxonInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Sylius\Resource\Factory\FactoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ProductTaxonAutocompleteChoiceType extends AbstractType
{
    /**
     * @param FactoryInterface<ProductTaxonInterface> $productTaxonFactory
     * @param RepositoryInterface<ProductTaxonInterface> $productTaxonRepository
     */
    public function __construct(
        private FactoryInterface $productTaxonFactory,
        private RepositoryInterface $productTaxonRepository,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['multiple']) {
            $builder->addModelTransformer(
                new RecursiveTransformer(
                    new ProductTaxonToTaxonTransformer(
                        $this->productTaxonFactory,
                        $this->productTaxonRepository,
                        $options['product'],
                    ),
                ),
            );
        }

        if (!$options['multiple']) {
            $builder->addModelTransformer(
                new ProductTaxonToTaxonTransformer(
                    $this->productTaxonFactory,
                    $this->productTaxonRepository,
                    $options['product'],
                ),
            );
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'resource' => 'sylius.taxon',
            'choice_name' => 'name',
            'choice_value' => 'code',
        ]);

        $resolver
            ->setRequired('product')
            ->setAllowedTypes('product', ProductInterface::class)
        ;
    }

    public function getParent(): string
    {
        return ResourceAutocompleteChoiceType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_product_taxon_autocomplete_choice';
    }
}
