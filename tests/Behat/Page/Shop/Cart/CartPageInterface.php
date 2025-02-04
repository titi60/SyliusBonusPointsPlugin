<?php

declare(strict_types=1);

namespace Tests\Titi60\SyliusBonusPointsPlugin\Behat\Page\Shop\Cart;

use Sylius\Behat\Page\Shop\Cart\SummaryPageInterface;
use Tests\Titi60\SyliusBonusPointsPlugin\Behat\Behaviour\ContainsErrorInterface;

interface CartPageInterface extends SummaryPageInterface, ContainsErrorInterface
{
    public function getNumberOfAvailableBonusPoints(): string;

    public function applyPoints(string $points): void;

    public function resetPoints(): void;
}
