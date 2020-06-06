<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Expense;
use App\Entity\ExpenseTransaction;
use App\Entity\Income;
use App\Entity\IncomeTransaction;
use App\Entity\Transaction;
use App\Entity\ValueObjects\Recurrence;
use App\Factory\TransactionFactory;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;

final class TransactionService
{
    private TransactionRepository $transactionRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->transactionRepository = $entityManager->getRepository(Transaction::class);
    }

    public function executeIncome(Income $income): IncomeTransaction
    {
        $recurrence = $income->getRecurrence();
        if ($recurrence->getType() === Recurrence::TYPE_NONE) {
            $transaction = TransactionFactory::createFromIncome($income);

            $this->transactionRepository->save($transaction);

            return $transaction;
        }

        throw new InvalidArgumentException("Only support incomes with no recurrence");
    }

    public function executeExpense(Expense $expense): ExpenseTransaction
    {
        $recurrence = $expense->getRecurrence();
        if ($recurrence->getType() === Recurrence::TYPE_NONE) {
            $transaction = TransactionFactory::createFromExpense($expense);

            $this->transactionRepository->save($transaction);

            return $transaction;
        }

        throw new InvalidArgumentException("Only support expenses with no recurrence");
    }
}
