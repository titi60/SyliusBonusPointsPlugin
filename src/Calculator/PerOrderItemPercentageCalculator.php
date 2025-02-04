<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Calculator;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Webmozart\Assert\Assert;

final class PerOrderItemPercentageCalculator implements BonusPointsStrategyCalculatorInterface
{
    /** @var string */
    public const TYPE = 'per_order_item_percentage';

    /**
     * @param OrderItemInterface|mixed $subject
     */
    public function calculate($subject, array $configuration, int $amountToDeduct = 0): int
    {
        Assert::isInstanceOf($subject, OrderItemInterface::class);

        /** @var OrderInterface $order */
        $order = $subject->getOrder();
        $channel = $order->getChannel();
        $code = null !== $channel ? $channel->getCode() : null;

        $configuration = $configuration[$code];

        $total = $subject->getTotal();

        if ($amountToDeduct < 0) {
            $total += $amountToDeduct;
        }

        return (int) (round($total * $configuration['percentToCalculatePoints']));
    }

    public function isPerOrderItem(): bool
    {
        return true;
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}
