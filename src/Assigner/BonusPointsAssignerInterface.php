<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Assigner;

use Sylius\Component\Core\Model\OrderInterface;

interface BonusPointsAssignerInterface
{
    public function assign(OrderInterface $order): void;
}
