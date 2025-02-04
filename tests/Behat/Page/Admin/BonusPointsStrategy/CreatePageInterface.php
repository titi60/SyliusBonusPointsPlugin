<?php

declare(strict_types=1);

namespace Tests\Titi60\SyliusBonusPointsPlugin\Behat\Page\Admin\BonusPointsStrategy;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;
use Tests\Titi60\SyliusBonusPointsPlugin\Behat\Behaviour\ContainsErrorInterface;

interface CreatePageInterface extends BaseCreatePageInterface, ContainsErrorInterface
{
    public function fillField(string $field, string $value): void;

    public function selectOption(string $field, string $value): void;

    public function addRule(string $ruleName): void;

    public function selectRuleOption(string $option, string $value, bool $multiple = false): void;

    public function selectAutocompleteRuleOption(string $option, $value, bool $multiple = false): void;

    public function fillRuleOption(string $option, string $value): void;

    public function fillName(string $name): void;

    public function enable(): void;

    public function checkField(string $field): void;
}
