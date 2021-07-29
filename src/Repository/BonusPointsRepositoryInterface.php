<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Repository;

use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface BonusPointsRepositoryInterface extends RepositoryInterface
{
    public function findAllCustomerPointsMovements(CustomerInterface $customer): array;
}
