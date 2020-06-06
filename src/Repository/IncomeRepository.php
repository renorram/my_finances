<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Income;
use Doctrine\ORM\EntityRepository;

class IncomeRepository extends EntityRepository
{
    /**
     * @param Income $income
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Income $income)
    {
        $this->_em->persist($income);
        $this->_em->flush();
    }
}
