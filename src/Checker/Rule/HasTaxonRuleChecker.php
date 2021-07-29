<?php

declare(strict_types=1);

namespace Titi60SyliusBonusPointsPlugin\Checker\Rule;

use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Webmozart\Assert\Assert;
use Sylius\Component\Core\Model\OrderItemInterface;

final class HasTaxonRuleChecker implements BonusPointsStrategyRuleCheckerInterface
{
    public const TYPE = 'has_taxon';

    /** @var TaxonRepositoryInterface */
    private $taxonRepository;

    public function __construct(TaxonRepositoryInterface $taxonRepository)
    {
        $this->taxonRepository = $taxonRepository;
    }

    public function isEligible(OrderItemInterface $orderItem, array $configuration): bool
    {
        Assert::keyExists($configuration, 'taxons');

        /** @var TaxonInterface[] $taxons */
        $taxons = $this->taxonRepository->findBy(['code' => $configuration['taxons']]);

        foreach ($taxons as $taxon) {
            if ($product->hasTaxon($taxon)) {
                return true;
            }
        }

        return false;
    }
}
