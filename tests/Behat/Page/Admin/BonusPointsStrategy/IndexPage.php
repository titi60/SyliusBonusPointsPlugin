<?php

declare(strict_types=1);

namespace Tests\Titi60\SyliusBonusPointsPlugin\Behat\Page\Admin\BonusPointsStrategy;

use Sylius\Behat\Page\Admin\Crud\IndexPage as BaseIndexPage;

class IndexPage extends BaseIndexPage implements IndexPageInterface
{
    public function deleteBonusPointsStrategy(string $name): void
    {
        $this->deleteResourceOnPage(['name' => $name]);
    }
}
