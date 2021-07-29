<?php

declare(strict_types=1);

namespace spec\Titi60\SyliusBonusPointsPlugin\Processor;

use Titi60\SyliusBonusPointsPlugin\Entity\BonusPointsInterface;
use Titi60\SyliusBonusPointsPlugin\Processor\ResetOrderBonusPointsProcessor;
use Titi60\SyliusBonusPointsPlugin\Processor\ResetOrderBonusPointsProcessorInterface;
use Titi60\SyliusBonusPointsPlugin\Purifier\OrderBonusPointsPurifierInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Tests\Titi60\SyliusBonusPointsPlugin\Entity\Order;

final class ResetOrderBonusPointsProcessorSpec extends ObjectBehavior
{
    function let(
        OrderBonusPointsPurifierInterface $orderBonusPointsPurifier,
        RepositoryInterface $bonusPointsRepository
    ): void {
        $this->beConstructedWith($orderBonusPointsPurifier, $bonusPointsRepository);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ResetOrderBonusPointsProcessor::class);
    }

    function it_implements_interface(): void
    {
        $this->shouldImplement(ResetOrderBonusPointsProcessorInterface::class);
    }

    function it_processes(
        Order $order,
        RepositoryInterface $bonusPointsRepository,
        BonusPointsInterface $bonusPoints,
        OrderBonusPointsPurifierInterface $orderBonusPointsPurifier
    ): void {
        $bonusPointsRepository->findOneBy(['order' => $order, 'isUsed' => true])->willReturn($bonusPoints);

        $bonusPointsRepository->findOneBy(['order' => $order, 'isUsed' => true])->shouldBeCalled();
        $orderBonusPointsPurifier->purify($bonusPoints)->shouldBeCalled();
        $bonusPointsRepository->add($bonusPoints)->shouldBeCalled();

        $this->process($order);
    }

    function it_does_not_process_if_it_does_not_find_bonus_points(
        Order $order,
        RepositoryInterface $bonusPointsRepository,
        BonusPointsInterface $bonusPoints,
        OrderBonusPointsPurifierInterface $orderBonusPointsPurifier
    ): void {
        $bonusPointsRepository->findOneBy(['order' => $order, 'isUsed' => true])->willReturn(null);

        $bonusPointsRepository->findOneBy(['order' => $order, 'isUsed' => true])->shouldBeCalled();
        $orderBonusPointsPurifier->purify($bonusPoints)->shouldNotBeCalled();
        $bonusPointsRepository->add($bonusPoints)->shouldNotBeCalled();

        $this->process($order);
    }
}
