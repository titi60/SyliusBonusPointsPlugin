<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Purifier;

use Titi60\SyliusBonusPointsPlugin\Entity\BonusPointsInterface;
use Titi60\SyliusBonusPointsPlugin\Entity\CustomerBonusPointsInterface;

interface OrderBonusPointsPurifierInterface
{
    public function purify(
        BonusPointsInterface $bonusPoints,
        CustomerBonusPointsInterface $customerBonusPoints = null
    ): void;
}
