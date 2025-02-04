<?php

declare(strict_types=1);

namespace Tests\Titi60\SyliusBonusPointsPlugin\Behat\Page\Admin\BonusPointsStrategy;

use Sylius\Behat\Page\Admin\Crud\IndexPageInterface as BaseIndexPageInterface;

interface IndexPageInterface extends BaseIndexPageInterface
{
    public function deleteBonusPointsStrategy(string $name): void;
}
