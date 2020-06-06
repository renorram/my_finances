<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\ExpenseTransaction;
use App\Entity\IncomeTransaction;
use App\Entity\Transaction;
use Doctrine\ORM\EntityRepository;
use Exception;

class TransactionRepository extends EntityRepository
{
    public function save(Transaction $transaction)
    {
        try {
            $this->_em->beginTransaction();

            if ($transaction instanceof ExpenseTransaction) {
                $this->processExpense($transaction);
            }

            if ($transaction instanceof IncomeTransaction) {
                $this->processIncome($transaction);
            }

            $this->_em->persist($transaction);
            $this->_em->flush();

            $this->_em->commit();
        } catch (Exception $e) {
            $this->_em->rollback();
            throw $e;
        }
    }

    private function processExpense(ExpenseTransaction $expenseTransaction): void
    {
        $expense = $expenseTransaction->getExpense();
        $user = $expense->getUser();
        $newBalance = $user->getBalance()->subtract($expense->getAmount());
        $user->setBalance($newBalance);

        $this->_em->persist($expense);
        $this->_em->persist($user);
    }

    private function processIncome(IncomeTransaction $incomeTransaction): void
    {
        $income = $incomeTransaction->getIncome();
        $user = $income->getUser();
        $newBalance = $user->getBalance()->add($income->getAmount());
        $user->setBalance($newBalance);

        $this->_em->persist($income);
        $this->_em->persist($user);
    }
}
