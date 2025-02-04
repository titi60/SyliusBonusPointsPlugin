<?php

declare(strict_types=1);

namespace Tests\Titi60\SyliusBonusPointsPlugin\Behat\Page\Admin\BonusPointsStrategy;

use Sylius\Behat\Page\Admin\Crud\UpdatePageInterface as BaseUpdatePageInterface;

interface UpdatePageInterface extends BaseUpdatePageInterface
{
    public function fillField(string $field, string $name): void;

    public function addRule(string $ruleName): void;

    public function selectRuleOption(string $option, string $value, bool $multiple = false): void;

    public function selectAutocompleteRuleOption(string $option, $value, bool $multiple = false): void;

    public function fillName(string $name): void;

    public function disable(): void;

    public function update(): void;

    public function fillRuleOption(string $option, string $value): void;
}
