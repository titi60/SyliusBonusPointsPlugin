<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Calculator;

use Titi60\SyliusBonusPointsPlugin\Entity\BonusPointsStrategyInterface;
use Sylius\Component\Core\Model\OrderItemInterface;

interface DelegatingBonusPointsStrategyCalculatorInterface
{
    public function calculate(OrderItemInterface $subject, BonusPointsStrategyInterface $bonusPointsStrategy, int $amountToDeduct): int;

    public function isPerOrderItem(BonusPointsStrategyInterface $bonusPointsStrategy): bool;
}
