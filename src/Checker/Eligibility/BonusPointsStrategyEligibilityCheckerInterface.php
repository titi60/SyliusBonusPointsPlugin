<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Checker\Eligibility;

use Titi60\SyliusBonusPointsPlugin\Entity\BonusPointsStrategyInterface;
use Sylius\Component\Core\Model\ProductInterface;

interface BonusPointsStrategyEligibilityCheckerInterface
{
    public function isEligible(ProductInterface $product, BonusPointsStrategyInterface $bonusPointsStrategy): bool;
}
