<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Context;

use Titi60\SyliusBonusPointsPlugin\Entity\CustomerBonusPointsInterface;

interface CustomerBonusPointsContextInterface
{
    public function getCustomerBonusPoints(): ?CustomerBonusPointsInterface;
}
