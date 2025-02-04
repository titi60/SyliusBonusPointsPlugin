<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Resolver;

use Sylius\Component\Core\Model\Customer;
use Sylius\Component\Core\Model\OrderInterface;

interface BonusPointsResolverInterface
{
    public function resolveBonusPoints(OrderInterface $withoutOrder = null, Customer $customer = null): int;
}
