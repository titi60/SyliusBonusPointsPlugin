<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Checker\Eligibility;

use Titi60\SyliusBonusPointsPlugin\Checker\Rule\BonusPointsStrategyRuleCheckerInterface;
use Titi60\SyliusBonusPointsPlugin\Entity\BonusPointsStrategyInterface;
use Titi60\SyliusBonusPointsPlugin\Entity\BonusPointsStrategyRuleInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;

final class BonusPointsStrategyRulesEligibilityChecker implements BonusPointsStrategyEligibilityCheckerInterface
{
    /** @var ServiceRegistryInterface */
    private $ruleRegistry;

    public function __construct(ServiceRegistryInterface $ruleRegistry)
    {
        $this->ruleRegistry = $ruleRegistry;
    }

    public function isEligible(ProductInterface $product, BonusPointsStrategyInterface $bonusPointsStrategy): bool
    {
        if (!$bonusPointsStrategy->hasRules()) {
            return false;
        }

        foreach ($bonusPointsStrategy->getRules() as $rule) {
            if (!$this->isEligibleToRule($product, $rule)) {
                return false;
            }
        }

        return true;
    }

    private function isEligibleToRule(ProductInterface $product, BonusPointsStrategyRuleInterface $rule): bool
    {
        /** @var BonusPointsStrategyRuleCheckerInterface $checker */
        $checker = $this->ruleRegistry->get((string) $rule->getType());

        return $checker->isEligible($product, $rule->getConfiguration());
    }
}
