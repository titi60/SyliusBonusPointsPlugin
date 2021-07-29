<?php

declare(strict_types=1);

namespace Titi60SyliusBonusPointsPlugin\Checker\Rule;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductInterface;

interface BonusPointsStrategyRuleCheckerInterface
{
    public function isEligible(OrderItemInterface $orderItem, array $configuration): bool;
}
