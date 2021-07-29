<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Purifier;

use Titi60\SyliusBonusPointsPlugin\Context\CustomerBonusPointsContextInterface;
use Titi60\SyliusBonusPointsPlugin\Entity\AdjustmentInterface;
use Titi60\SyliusBonusPointsPlugin\Entity\BonusPointsInterface;
use Titi60\SyliusBonusPointsPlugin\Entity\CustomerBonusPointsInterface;
use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Core\Model\OrderInterface;

final class OrderBonusPointsPurifier implements OrderBonusPointsPurifierInterface
{
    /** @var CustomerBonusPointsContextInterface */
    private $customerBonusPointsContext;

    /** @var ObjectManager */
    private $persistenceManager;

    public function __construct(
        CustomerBonusPointsContextInterface $customerBonusPointsContext,
        ObjectManager $persistenceManager
    ) {
        $this->customerBonusPointsContext = $customerBonusPointsContext;
        $this->persistenceManager = $persistenceManager;
    }

    public function purify(
        BonusPointsInterface $bonusPoints,
        CustomerBonusPointsInterface $customerBonusPoints = null
    ): void {
        /** @var OrderInterface $order */
        $order = $bonusPoints->getOrder();

        if (null === $customerBonusPoints) {
            $customerBonusPoints = $this->customerBonusPointsContext->getCustomerBonusPoints();
        }

        /** @var CustomerBonusPointsInterface $customerBonusPoints */
        if ($order->getCustomer() !== $customerBonusPoints->getCustomer()) {
            return;
        }

        $order->removeAdjustmentsRecursively(AdjustmentInterface::ORDER_BONUS_POINTS_ADJUSTMENT);
        $customerBonusPoints->removeBonusPointsUsed($bonusPoints);
        $bonusPoints->setPoints(0);

        $this->persistenceManager->persist($customerBonusPoints);
        $this->persistenceManager->persist($order);
    }
}
