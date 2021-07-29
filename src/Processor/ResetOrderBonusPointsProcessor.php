<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Processor;

use Titi60\SyliusBonusPointsPlugin\Entity\BonusPointsInterface;
use Titi60\SyliusBonusPointsPlugin\Purifier\OrderBonusPointsPurifierInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class ResetOrderBonusPointsProcessor implements ResetOrderBonusPointsProcessorInterface
{
    /** @var OrderBonusPointsPurifierInterface */
    private $orderBonusPointsPurifier;

    /** @var RepositoryInterface */
    private $bonusPointsRepository;

    public function __construct(
        OrderBonusPointsPurifierInterface $orderBonusPointsPurifier,
        RepositoryInterface $bonusPointsRepository
    ) {
        $this->orderBonusPointsPurifier = $orderBonusPointsPurifier;
        $this->bonusPointsRepository = $bonusPointsRepository;
    }

    public function process(OrderInterface $order): void
    {
        /** @var BonusPointsInterface|null $bonusPoints */
        $bonusPoints = $this->bonusPointsRepository->findOneBy(['order' => $order, 'isUsed' => true]);

        if (null !== $bonusPoints) {
            $this->orderBonusPointsPurifier->purify($bonusPoints);

            $this->bonusPointsRepository->add($bonusPoints);
        }
    }
}
