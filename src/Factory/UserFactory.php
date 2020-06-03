<?php declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use App\Entity\ValueObjects\Money;
use DateTime;

final class UserFactory
{
    public static function create(string $email, string $password, string $preferedCurrency): User
    {
        $user = new User();
        $user->setEmail($email)
            ->setPreferredCurrency($preferedCurrency)
            ->setPassword($password)
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime())
            ->setBalance(Money::newFromValueAndCurrency(0, $preferedCurrency));

        return $user;
    }
}
