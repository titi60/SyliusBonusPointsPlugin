<?php

declare(strict_types=1);

namespace Titi60SyliusBonusPointsPlugin\Checker\Eligibility;

use Titi60SyliusBonusPointsPlugin\Entity\BonusPointsStrategyInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\OrderItemInterface;

interface BonusPointsStrategyEligibilityCheckerInterface
{
    public function isEligible(OrderItemInterface $orderItem, BonusPointsStrategyInterface $bonusPointsStrategy): bool;
}
