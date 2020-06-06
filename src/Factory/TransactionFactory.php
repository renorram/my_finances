<?php declare(strict_types=1);

namespace App\Factory;

use App\Entity\Expense;
use App\Entity\ExpenseTransaction;
use App\Entity\Income;
use App\Entity\IncomeTransaction;
use App\Entity\Transaction;
use DateTime;
use InvalidArgumentException;

final class TransactionFactory
{
    public static function create(object $entity): Transaction
    {
        if ($entity instanceof Expense) {
            return self::createFromExpense($entity);
        }

        if ($entity instanceof Income) {
            return self::createFromIncome($entity);
        }

        throw new InvalidArgumentException(
            sprintf("The entity %s is not a valid transaction type.", get_class($entity))
        );
    }

    public static function createFromExpense(Expense $expense): ExpenseTransaction
    {
        $now = new DateTime();

        return (new ExpenseTransaction())
            ->setExpense($expense)
            ->setDescription($expense->getDescription())
            ->setCreatedAt($now)
            ->setUpdatedAt($now);
    }

    public static function createFromIncome(Income $income): IncomeTransaction
    {
        $now = new DateTime();

        return (new IncomeTransaction())
            ->setIncome($income)
            ->setDescription($income->getDescription())
            ->setCreatedAt($now)
            ->setUpdatedAt($now);
    }
}
