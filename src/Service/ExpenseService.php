<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Expense;
use App\Entity\ValueObjects\Recurrence;
use App\Exception\DomainValidationException;
use App\Repository\ExpenseRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ExpenseService
{
    private ExpenseRepository $expenseRepository;
    private ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->expenseRepository = $entityManager->getRepository(Expense::class);
        $this->validator = $validator;
    }

    /**
     * @param Expense $expense
     * @return Expense
     * @throws DomainValidationException
     */
    public function createOrFail(Expense $expense): Expense
    {
        $errors = $this->validator->validate($expense);
        if (count($errors) > 0) {
            throw new DomainValidationException($errors);
        }

        $expense->setPaid(self::isExpensePaid($expense));
        $this->expenseRepository->save($expense);

        return $expense;
    }

    /**
     * @param Expense $expense
     *
     * @return bool
     * @todo use transactions made instead of recurrence type
     */
    public static function isExpensePaid(Expense $expense): bool
    {
        $recurrence = $expense->getRecurrence();
        $now = new DateTime();

        if ($recurrence->getType() === Recurrence::TYPE_NONE) {
            return $recurrence->getDueDate() > $now;
        }

        return false;
    }
}
