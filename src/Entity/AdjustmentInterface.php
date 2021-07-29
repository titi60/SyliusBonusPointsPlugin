<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Entity;

use Sylius\Component\Order\Model\AdjustmentInterface as BaseAdjustmentInterface;

interface AdjustmentInterface extends BaseAdjustmentInterface
{
    public const ORDER_BONUS_POINTS_ADJUSTMENT = 'order_bonus_points';
}
