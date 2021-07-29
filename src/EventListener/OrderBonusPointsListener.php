<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\EventListener;

use Titi60\SyliusBonusPointsPlugin\Context\CustomerBonusPointsContextInterface;
use Titi60\SyliusBonusPointsPlugin\Entity\BonusPointsAwareInterface;
use Titi60\SyliusBonusPointsPlugin\Entity\BonusPointsInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Webmozart\Assert\Assert;

final class OrderBonusPointsListener
{
    /** @var EntityRepository */
    private $bonusPointsRepository;

    /** @var FactoryInterface */
    private $bonusPointsFactory;

    /** @var CustomerBonusPointsContextInterface */
    private $customerBonusPointsContext;

    public function __construct(
        EntityRepository $bonusPointsRepository,
        FactoryInterface $bonusPointsFactory,
        CustomerBonusPointsContextInterface $customerBonusPointsContext
    ) {
        $this->bonusPointsRepository = $bonusPointsRepository;
        $this->bonusPointsFactory = $bonusPointsFactory;
        $this->customerBonusPointsContext = $customerBonusPointsContext;
    }

    public function assignBonusPoints(ResourceControllerEvent $event): void
    {
        /** @var OrderInterface|BonusPointsAwareInterface $order */
        $order = $event->getSubject();

        Assert::isInstanceOf($order, OrderInterface::class);
        Assert::isInstanceOf($order, BonusPointsAwareInterface::class);

        $points = (int) ($order->getBonusPoints());

        if (null === $order->getBonusPoints()) {
            return;
        }

        $customerBonusPoints = $this->customerBonusPointsContext->getCustomerBonusPoints();

        if (null === $customerBonusPoints) {
            return;
        }

        /** @var BonusPointsInterface $bonusPoints */
        $bonusPoints = $this->bonusPointsRepository->findOneBy(['order' => $order, 'isUsed' => true]) ??
            $this->bonusPointsFactory->createNew()
        ;

        $bonusPoints->setIsUsed(true);
        $bonusPoints->setPoints($points);
        $bonusPoints->setOrder($order);

        $customerBonusPoints->addBonusPointsUsed($bonusPoints);

        $this->bonusPointsRepository->add($bonusPoints);
    }
}
