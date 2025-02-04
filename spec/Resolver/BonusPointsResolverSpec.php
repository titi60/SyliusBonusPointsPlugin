<?php

declare(strict_types=1);

namespace spec\Titi60\SyliusBonusPointsPlugin\Resolver;

use Titi60\SyliusBonusPointsPlugin\Repository\BonusPointsRepositoryInterface;
use Titi60\SyliusBonusPointsPlugin\Resolver\BonusPointsResolver;
use Titi60\SyliusBonusPointsPlugin\Resolver\BonusPointsResolverInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Sylius\Component\Customer\Model\CustomerInterface;

final class BonusPointsResolverSpec extends ObjectBehavior
{
    function let(
        BonusPointsRepositoryInterface $bonusPointsRepository,
        CustomerContextInterface $customerContext
    ): void
    {
        $this->beConstructedWith($bonusPointsRepository, $customerContext);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(BonusPointsResolver::class);
    }

    function it_implements_bonus_points_resolver_interface(): void
    {
        $this->shouldHaveType(BonusPointsResolverInterface::class);
    }

    function it_resolves(
        CustomerInterface $customer,
        BonusPointsRepositoryInterface $bonusPointsRepository
    ): void
    {

        $bonusPointsRepository->findAllCustomerPointsMovements($customer)->willReturn([]);

        $this->resolveBonusPoints()->shouldReturn(0);
    }
}
