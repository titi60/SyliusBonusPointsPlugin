<?php

declare(strict_types=1);

namespace spec\Titi60\SyliusBonusPointsPlugin\Calculator;

use Titi60\SyliusBonusPointsPlugin\Calculator\BonusPointsStrategyCalculatorInterface;
use Titi60\SyliusBonusPointsPlugin\Calculator\DelegatingBonusPointsStrategyCalculator;
use Titi60\SyliusBonusPointsPlugin\Calculator\DelegatingBonusPointsStrategyCalculatorInterface;
use Titi60\SyliusBonusPointsPlugin\Calculator\PerOrderPriceCalculator;
use Titi60\SyliusBonusPointsPlugin\Checker\Eligibility\BonusPointsStrategyEligibilityCheckerInterface;
use Titi60\SyliusBonusPointsPlugin\Entity\BonusPointsStrategyInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;

final class DelegatingBonusPointsStrategyCalculatorSpec extends ObjectBehavior
{
    function let(
        ServiceRegistryInterface $registry,
        BonusPointsStrategyEligibilityCheckerInterface $bonusPointsStrategyEligibilityChecker
    ): void {
        $this->beConstructedWith($registry, $bonusPointsStrategyEligibilityChecker);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(DelegatingBonusPointsStrategyCalculator::class);
    }

    function it_implements_bonus_points_resolver_interface(): void
    {
        $this->shouldHaveType(DelegatingBonusPointsStrategyCalculatorInterface::class);
    }

    function it_calculates(
        ServiceRegistryInterface $registry,
        BonusPointsStrategyEligibilityCheckerInterface $bonusPointsStrategyEligibilityChecker,
        BonusPointsStrategyInterface $bonusPointsStrategy,
        ProductInterface $product,
        OrderItemInterface $orderItem,
        BonusPointsStrategyCalculatorInterface $calculator
    ): void {
        $bonusPointsStrategy->getCalculatorType()->willReturn(PerOrderPriceCalculator::TYPE);
        $registry->get(PerOrderPriceCalculator::TYPE)->willReturn($calculator);
        $orderItem->getProduct()->willReturn($product);
        $bonusPointsStrategyEligibilityChecker->isEligible($product, $bonusPointsStrategy)->willReturn(true);
        $bonusPointsStrategy->getCalculatorConfiguration()->willReturn(['numberOfPointsEarnedPerOneCurrency' => 2]);
        $calculator->calculate($orderItem, ['numberOfPointsEarnedPerOneCurrency' => 2], 0)->willReturn(88);

        $bonusPointsStrategy->getCalculatorType()->shouldBeCalled();
        $registry->get(PerOrderPriceCalculator::TYPE)->shouldBeCalled();
        $orderItem->getProduct()->shouldBeCalled();
        $bonusPointsStrategyEligibilityChecker->isEligible($product, $bonusPointsStrategy)->shouldBeCalled();
        $bonusPointsStrategy->getCalculatorConfiguration()->shouldBeCalled();
        $calculator->calculate($orderItem, ['numberOfPointsEarnedPerOneCurrency' => 2], 0)->shouldBeCalled();

        $this->calculate($orderItem, $bonusPointsStrategy)->shouldReturn(88);
    }

    function it_calculates_when_is_no_eligible(
        ServiceRegistryInterface $registry,
        BonusPointsStrategyEligibilityCheckerInterface $bonusPointsStrategyEligibilityChecker,
        BonusPointsStrategyInterface $bonusPointsStrategy,
        OrderItemInterface $orderItem,
        ProductInterface $product,
        BonusPointsStrategyCalculatorInterface $calculator
    ): void {
        $bonusPointsStrategy->getCalculatorType()->willReturn(PerOrderPriceCalculator::TYPE);
        $registry->get(PerOrderPriceCalculator::TYPE)->willReturn($calculator);
        $orderItem->getProduct()->willReturn($product);
        $bonusPointsStrategyEligibilityChecker->isEligible($product, $bonusPointsStrategy)->willReturn(false);

        $bonusPointsStrategy->getCalculatorType()->shouldBeCalled();
        $registry->get(PerOrderPriceCalculator::TYPE)->shouldBeCalled();
        $orderItem->getProduct()->shouldBeCalled();
        $bonusPointsStrategyEligibilityChecker->isEligible($product, $bonusPointsStrategy)->shouldBeCalled();

        $this->calculate($orderItem, $bonusPointsStrategy)->shouldReturn(0);
    }

    function it_returns_true_if_calculator_is_per_order_item(
        ServiceRegistryInterface $registry,
        BonusPointsStrategyInterface $bonusPointsStrategy,
        BonusPointsStrategyCalculatorInterface $calculator
    ): void {
        $bonusPointsStrategy->getCalculatorType()->willReturn(PerOrderPriceCalculator::TYPE);
        $registry->get(PerOrderPriceCalculator::TYPE)->willReturn($calculator);
        $calculator->isPerOrderItem()->willReturn(true);

        $bonusPointsStrategy->getCalculatorType()->shouldBeCalled();
        $registry->get(PerOrderPriceCalculator::TYPE)->shouldBeCalled();
        $calculator->isPerOrderItem()->shouldBeCalled();

        $this->isPerOrderItem($bonusPointsStrategy)->shouldReturn(true);
    }

    function it_returns_true_if_calculator_is_not_per_order_item(
        ServiceRegistryInterface $registry,
        BonusPointsStrategyInterface $bonusPointsStrategy,
        BonusPointsStrategyCalculatorInterface $calculator
    ): void {
        $bonusPointsStrategy->getCalculatorType()->willReturn(PerOrderPriceCalculator::TYPE);
        $registry->get(PerOrderPriceCalculator::TYPE)->willReturn($calculator);
        $calculator->isPerOrderItem()->willReturn(false);

        $bonusPointsStrategy->getCalculatorType()->shouldBeCalled();
        $registry->get(PerOrderPriceCalculator::TYPE)->shouldBeCalled();
        $calculator->isPerOrderItem()->shouldBeCalled();

        $this->isPerOrderItem($bonusPointsStrategy)->shouldReturn(false);
    }
}
