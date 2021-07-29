<?php

declare(strict_types=1);

namespace spec\Titi60\SyliusBonusPointsPlugin\Validator\Constraints;

use Titi60\SyliusBonusPointsPlugin\Entity\BonusPointsAwareInterface;
use Titi60\SyliusBonusPointsPlugin\Resolver\BonusPointsResolverInterface;
use Titi60\SyliusBonusPointsPlugin\Validator\Constraints\BonusPointsAvailability;
use Titi60\SyliusBonusPointsPlugin\Validator\Constraints\BonusPointsAvailabilityValidator;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Validator\ConstraintValidator;
use Tests\Titi60\SyliusBonusPointsPlugin\Entity\Order;

final class BonusPointsAvailabilityValidatorSpec extends ObjectBehavior
{
    function let(
        BonusPointsResolverInterface $bonusPointsResolver,
        RepositoryInterface $bonusPointsRepository
    ): void
    {
        $this->beConstructedWith($bonusPointsResolver, $bonusPointsRepository);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(BonusPointsAvailabilityValidator::class);
    }

    function it_extends_constraint_validator_class(): void
    {
        $this->shouldHaveType(ConstraintValidator::class);
    }

    function it_validates(
        Order $order,
        RepositoryInterface $bonusPointsRepository
    ): void
    {
        $bonusPointsAvailabilityConstraint = new BonusPointsAvailability();

        $order->getBonusPoints()->willReturn(null);

        $bonusPointsRepository->findOneBy(['order' => $order, 'isUsed' => true,])->willReturn(null);
        $bonusPointsRepository->findOneBy(['order' => $order, 'isUsed' => true,])->shouldBeCalled();
        $order->getBonusPoints()->shouldBeCalled();
        $order->getBonusPoints()->shouldBeCalled();

        $this->validate($order, $bonusPointsAvailabilityConstraint);
    }
}
