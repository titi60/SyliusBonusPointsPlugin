<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Repository;

use Titi60\SyliusBonusPointsPlugin\Entity\CustomerBonusPoints;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Customer\Model\CustomerInterface;

class BonusPointsRepository extends EntityRepository implements BonusPointsRepositoryInterface
{
    public function findAllCustomerPointsMovements(CustomerInterface $customer): array
    {
        return $this->createQueryBuilder('bp')
            ->leftJoin(CustomerBonusPoints::class, 'cbp', 'WITH', 'cbp.customer = :customer')
            ->leftJoin('cbp.bonusPoints', 'bonusPointsNotUsed')
            ->leftJoin('cbp.bonusPointsUsed', 'bonusPointsUsed')
            ->andWhere('bonusPointsUsed.id = bp.id OR bonusPointsNotUsed.id = bp.id')
            ->setParameter('customer', $customer)
            ->addOrderBy('bp.updatedAt', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
