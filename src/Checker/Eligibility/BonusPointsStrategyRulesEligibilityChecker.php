<?php

declare(strict_types=1);

namespace BitBag\SyliusBonusPointsPlugin\Checker\Eligibility;

use BitBag\SyliusBonusPointsPlugin\Checker\Rule\BonusPointsStrategyRuleCheckerInterface;
use BitBag\SyliusBonusPointsPlugin\Entity\BonusPointsStrategyInterface;
use BitBag\SyliusBonusPointsPlugin\Entity\BonusPointsStrategyRuleInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Sylius\Component\Core\Model\OrderItemInterface;

final class BonusPointsStrategyRulesEligibilityChecker implements BonusPointsStrategyEligibilityCheckerInterface
{
    /** @var ServiceRegistryInterface */
    private $ruleRegistry;

    public function __construct(ServiceRegistryInterface $ruleRegistry)
    {
        $this->ruleRegistry = $ruleRegistry;
    }

    public function isEligible(OrderItemInterface $orderItem, BonusPointsStrategyInterface $bonusPointsStrategy): bool
    {
        $product = $orderItem->getProduct();
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

    private function isEligibleToRule(OrderItemInterface $orderItem, BonusPointsStrategyRuleInterface $rule): bool
    {
        $product = $orderItem->getProduct();
        /** @var BonusPointsStrategyRuleCheckerInterface $checker */
        $checker = $this->ruleRegistry->get((string) $rule->getType());

        return $checker->isEligible($product, $rule->getConfiguration());
    }
}
