<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Processor;

use Sylius\Component\Order\Model\OrderInterface;

interface ResetOrderBonusPointsProcessorInterface
{
    public function process(OrderInterface $order): void;
}
