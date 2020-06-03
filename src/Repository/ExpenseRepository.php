<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Expense;
use Doctrine\ORM\EntityRepository;

class ExpenseRepository extends EntityRepository
{
    public function save(Expense $expense): void
    {
        $this->_em->persist($expense);
        $this->_em->flush();
    }
}
