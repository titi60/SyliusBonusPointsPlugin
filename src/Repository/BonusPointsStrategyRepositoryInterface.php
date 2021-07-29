<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Repository;

use Sylius\Component\Resource\Repository\RepositoryInterface;

interface BonusPointsStrategyRepositoryInterface extends RepositoryInterface
{
    public function findAllActive(): array;

    public function findActiveByCalculatorType(string $calculatorType): array;
}
