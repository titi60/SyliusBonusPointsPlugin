<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Form\Type\Rule;

use Sylius\Bundle\TaxonomyBundle\Form\Type\TaxonAutocompleteChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class HasTaxonConfigurationType extends AbstractType
{
    /** @var DataTransformerInterface */
    private $taxonsToCodesTransformer;

    public function __construct(DataTransformerInterface $taxonsToCodesTransformer)
    {
        $this->taxonsToCodesTransformer = $taxonsToCodesTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('taxons', TaxonAutocompleteChoiceType::class, [
                'label' => 'sylius.form.promotion_rule.has_taxon.taxons',
                'multiple' => true,
                'constraints' => [
                    new NotBlank(['groups' => ['bitbag_sylius_bonus_points']]),
                ],
            ])
        ;

        $builder->get('taxons')->addModelTransformer($this->taxonsToCodesTransformer);
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_bonus_points_strategy_rule_has_taxon_configuration';
    }
}
