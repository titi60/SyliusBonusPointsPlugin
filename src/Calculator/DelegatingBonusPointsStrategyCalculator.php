<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Calculator;

use Titi60\SyliusBonusPointsPlugin\Checker\Eligibility\BonusPointsStrategyEligibilityCheckerInterface;
use Titi60\SyliusBonusPointsPlugin\Entity\BonusPointsStrategyInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;

final class DelegatingBonusPointsStrategyCalculator implements DelegatingBonusPointsStrategyCalculatorInterface
{
    /** @var ServiceRegistryInterface */
    private $registry;

    /** @var BonusPointsStrategyEligibilityCheckerInterface */
    private $bonusPointsStrategyEligibilityChecker;

    public function __construct(
        ServiceRegistryInterface $registry,
        BonusPointsStrategyEligibilityCheckerInterface $bonusPointsStrategyEligibilityChecker
    ) {
        $this->registry = $registry;
        $this->bonusPointsStrategyEligibilityChecker = $bonusPointsStrategyEligibilityChecker;
    }

    public function calculate(OrderItemInterface $subject, BonusPointsStrategyInterface $bonusPointsStrategy, int $amountToDeduct = 0): int
    {
        /** @var BonusPointsStrategyCalculatorInterface $calculator */
        $calculator = $this->registry->get((string) $bonusPointsStrategy->getCalculatorType());
        $product = $subject->getProduct();

        if (null === $product) {
            return 0;
        }

        $isEligible = $this->bonusPointsStrategyEligibilityChecker->isEligible($subject, $bonusPointsStrategy);

        return $isEligible ? $calculator->calculate($subject, $bonusPointsStrategy->getCalculatorConfiguration(), $amountToDeduct) : 0;
    }

    public function isPerOrderItem(BonusPointsStrategyInterface $bonusPointsStrategy): bool
    {
        /** @var BonusPointsStrategyCalculatorInterface $calculator */
        $calculator = $this->registry->get((string) $bonusPointsStrategy->getCalculatorType());

        return $calculator->isPerOrderItem();
    }
}
