<?php declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\ValueObjects\Money;
use App\Entity\ValueObjects\Recurrence;
use App\Factory\ExpenseFactory;
use App\Factory\UserFactory;
use App\Service\ExpenseService;
use App\Service\UserService;
use App\Tests\AbstractKernelTestCase;
use DateTime;

final class ExpenseServiceTest extends AbstractKernelTestCase
{
    private ExpenseService $expenseService;
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = self::$container->get(UserService::class);
        $this->expenseService = self::$container->get(ExpenseService::class);
    }

    public function testIfCanCreateExpense()
    {
        $user = UserFactory::create(
            $this->faker->firstName,
            $this->faker->lastName,
            $this->faker->email,
            $this->faker->password,
            $this->faker->currencyCode
        );
        $money = Money::createForUser(0, $user);
        $this->userService->registerUserOrFail($user);

        $expense = ExpenseFactory::create(
            $this->faker->words(5, true),
            $user,
            $money,
            Recurrence::createNonRecurrent(new DateTime())
        );

        $this->expenseService->createOrFail($expense);

        $this->assertNotNull($expense->getId());
    }
}
