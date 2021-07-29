<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Entity;

trait BonusPointsAwareTrait
{
    /** @var int|null */
    protected $bonusPoints;

    public function getBonusPoints(): ?int
    {
        return $this->bonusPoints;
    }

    public function setBonusPoints(?int $bonusPoints): void
    {
        $this->bonusPoints = $bonusPoints;
    }
}
