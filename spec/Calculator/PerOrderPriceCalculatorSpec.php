<?php

declare(strict_types=1);

namespace spec\Titi60\SyliusBonusPointsPlugin\Calculator;

use Titi60\SyliusBonusPointsPlugin\Calculator\BonusPointsStrategyCalculatorInterface;
use Titi60\SyliusBonusPointsPlugin\Calculator\PerOrderPriceCalculator;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;

final class PerOrderPriceCalculatorSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(PerOrderPriceCalculator::class);
    }

    function it_implements_bonus_points_resolver_interface(): void
    {
        $this->shouldHaveType(BonusPointsStrategyCalculatorInterface::class);
    }

    function it_calculates(OrderItemInterface $orderItem): void
    {
        $configuration = ['numberOfPointsEarnedPerOneCurrency' => 2];

        $orderItem->getTotal()->willReturn(10000);

        $orderItem->getTotal()->shouldBeCalled();

        $this->calculate($orderItem, $configuration)->shouldReturn(200);
    }
}
