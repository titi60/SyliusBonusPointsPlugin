<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Calculator;

interface BonusPointsStrategyCalculatorInterface
{
    /**
     * @param mixed $subject
     */
    public function calculate($subject, array $configuration, int $amountToDeduct = 0): int;

    public function isPerOrderItem(): bool;

    public function getType(): string;
}
