<?php declare(strict_types=1);

namespace App\Factory;

use App\Entity\Expense;
use App\Entity\User;
use App\Entity\ValueObjects\Money;
use App\Entity\ValueObjects\Recurrence;
use App\Service\ExpenseService;
use DateTime;

final class ExpenseFactory
{
    public static function create(
        string $description,
        User $user,
        Money $amount,
        Recurrence $recurrence
    ): Expense {
        $now = new DateTime();

        return (new Expense())
            ->setDescription($description)
            ->setUser($user)
            ->setAmount($amount)
            ->setPaid(ExpenseService::isExpensePaid($recurrence))
            ->setRecurrence($recurrence)
            ->setCreatedAt($now)
            ->setUpdatedAt($now);
    }
}
