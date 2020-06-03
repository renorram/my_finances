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

    public function createOrFail(Expense $expense): Expense
    {
        $errors = $this->validator->validate($expense);
        if (count($errors) > 0) {
            throw new DomainValidationException($errors);
        }

        $this->expenseRepository->save($expense);

        return $expense;
    }

    /**
     * @todo deal of other types of recurrence
     * @param Recurrence $recurrence
     *
     * @return bool
     */
    public static function isExpensePaid(Recurrence $recurrence): bool
    {
        $now = new DateTime();

        if ($recurrence->getType() === Recurrence::TYPE_NONE) {
            return $recurrence->getDueDate() > $now;
        }

        return false;
    }
}
