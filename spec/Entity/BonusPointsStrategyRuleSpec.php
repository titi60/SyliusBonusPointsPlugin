<?php

declare(strict_types=1);

namespace spec\Titi60\SyliusBonusPointsPlugin\Entity;

use Titi60\SyliusBonusPointsPlugin\Entity\BonusPointsStrategyInterface;
use Titi60\SyliusBonusPointsPlugin\Entity\BonusPointsStrategyRule;
use Titi60\SyliusBonusPointsPlugin\Entity\BonusPointsStrategyRuleInterface;
use PhpSpec\ObjectBehavior;

final class BonusPointsStrategyRuleSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(BonusPointsStrategyRule::class);
    }

    function it_implements_blacklisting_rule_interface(): void
    {
        $this->shouldHaveType(BonusPointsStrategyRuleInterface::class);
    }

    function it_has_null_id_by_default(): void
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_no_type_by_default(): void
    {
        $this->getType()->shouldReturn(null);
    }

    function it_has_no_bonus_points_strategy_by_default(): void
    {
        $this->getBonusPointsStrategy()->shouldReturn(null);
    }

    function it_has_empty_configuration_by_default(): void
    {
        $this->getConfiguration()->shouldReturn([]);
    }

    function it_sets_type(): void
    {
        $this->setType('has_taxon');

        $this->getType()->shouldReturn('has_taxon');
    }

    function it_sets_bonus_points_strategy(BonusPointsStrategyInterface $bonusPointsStrategy): void
    {
        $this->setBonusPointsStrategy($bonusPointsStrategy);

        $this->getBonusPointsStrategy()->shouldReturn($bonusPointsStrategy);
    }

    function it_sets_configuration(): void
    {
        $configuration = ['numberOfPointsGivenPerOneCurrency' => 2];

        $this->setConfiguration($configuration);

        $this->getConfiguration()->shouldReturn($configuration);
    }
}
