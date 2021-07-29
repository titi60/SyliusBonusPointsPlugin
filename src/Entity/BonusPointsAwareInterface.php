<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Entity;

interface BonusPointsAwareInterface
{
    public function getBonusPoints(): ?int;

    public function setBonusPoints(?int $bonusPoints): void;
}
