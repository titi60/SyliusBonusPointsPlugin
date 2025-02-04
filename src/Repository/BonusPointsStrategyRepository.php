<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class BonusPointsStrategyRepository extends EntityRepository implements BonusPointsStrategyRepositoryInterface
{
    public function findAllActive(): array
    {
        return $this->createQueryBuilder('o')
            ->where('o.enabled = true')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findActiveByCalculatorType(string $calculatorType): array
    {
        return $this->createQueryBuilder('o')
            ->where('o.enabled = true')
            ->andWhere('o.calculatorType = :calculatorType')
            ->setParameter('calculatorType', $calculatorType)
            ->getQuery()
            ->getResult()
        ;
    }
}
