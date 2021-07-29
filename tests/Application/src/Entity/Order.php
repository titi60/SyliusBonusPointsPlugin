<?php

declare(strict_types=1);

namespace Tests\Titi60\SyliusBonusPointsPlugin\Entity;

use Titi60\SyliusBonusPointsPlugin\Entity\BonusPointsAwareInterface;
use Titi60\SyliusBonusPointsPlugin\Entity\BonusPointsAwareTrait;
use Sylius\Component\Core\Model\Order as BaseOrder;
use Sylius\Component\Core\Model\OrderInterface;

class Order extends BaseOrder implements OrderInterface, BonusPointsAwareInterface
{
    use BonusPointsAwareTrait;
}
