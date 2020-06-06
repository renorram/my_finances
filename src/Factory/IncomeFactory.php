<?php declare(strict_types=1);

namespace App\Factory;

use App\Entity\Income;
use App\Entity\User;
use App\Entity\ValueObjects\Money;
use App\Entity\ValueObjects\Recurrence;
use DateTime;

final class IncomeFactory
{
    public static function create(
        string $description,
        User $user,
        Money $amount,
        Recurrence $recurrence
    ): Income {
        $now = new DateTime();

        return (new Income())
            ->setDescription($description)
            ->setUser($user)
            ->setAmount($amount)
            ->setRecurrence($recurrence)
            ->setCreatedAt($now)
            ->setUpdatedAt($now);
    }
}
