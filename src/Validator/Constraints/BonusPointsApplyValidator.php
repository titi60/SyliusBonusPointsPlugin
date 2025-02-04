<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Validator\Constraints;

use Titi60\SyliusBonusPointsPlugin\Calculator\PerOrderPriceCalculator;
use Titi60\SyliusBonusPointsPlugin\Repository\BonusPointsStrategyRepositoryInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class BonusPointsApplyValidator extends ConstraintValidator
{
    /** @var BonusPointsStrategyRepositoryInterface */
    private $bonusPointsStrategyRepository;

    /** @var CartContextInterface */
    private $cartContext;

    public function __construct(
        BonusPointsStrategyRepositoryInterface $bonusPointsStrategyRepository,
        CartContextInterface $cartContext
    ) {
        $this->bonusPointsStrategyRepository = $bonusPointsStrategyRepository;
        $this->cartContext = $cartContext;
    }

    public function validate($bonusPoints, Constraint $constraint): void
    {
        if (null === $bonusPoints) {
            return;
        }

        if ($this->canFitBonusPointsToOrder($bonusPoints)) {
            /** @var BonusPointsApply $constraint */
            $this->context->buildViolation($constraint->exceedOrderItemsTotalMessage)->addViolation();

            return;
        }

        $bonusPointsStrategies = $this->bonusPointsStrategyRepository->findActiveByCalculatorType(PerOrderPriceCalculator::TYPE);

        if (\count($bonusPointsStrategies) === 0) {
            return;
        }

        if ($bonusPoints % 100 !== 0) {
            $this->context->getViolations()->remove(0);
            /** @var BonusPointsApply $constraint */
            $this->context->buildViolation($constraint->invalidBonusPointsValueMessage)->addViolation();

            return;
        }
    }

    private function canFitBonusPointsToOrder(int $bonusPoints): bool
    {
        $order = $this->cartContext->getCart();

        return $order->getItemsTotal() < $bonusPoints;
    }
}
