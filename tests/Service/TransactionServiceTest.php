<?php declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\ExpenseTransaction;
use App\Entity\IncomeTransaction;
use App\Entity\ValueObjects\Money;
use App\Entity\ValueObjects\Recurrence;
use App\Factory\ExpenseFactory;
use App\Factory\IncomeFactory;
use App\Factory\UserFactory;
use App\Service\TransactionService;
use App\Service\UserService;
use App\Tests\AbstractKernelTestCase;
use DateTime;

class TransactionServiceTest extends AbstractKernelTestCase
{
    private TransactionService $transactionService;
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transactionService = self::$container->get(TransactionService::class);
        $this->userService = self::$container->get(UserService::class);
    }

    public function testCanExecuteExpenseTransaction()
    {
        $user = UserFactory::create(
            $this->faker->firstName,
            $this->faker->lastName,
            $this->faker->email,
            $this->faker->password,
            $this->faker->currencyCode
        );
        $user->setBalance(Money::createForUser(500, $user));

        $expense = ExpenseFactory::create(
            $this->faker->words(4, true),
            $user,
            Money::createForUser(200, $user),
            Recurrence::createNonRecurrent(new DateTime())
        );

        $result = $this->transactionService->executeExpense($expense);

        $this->assertInstanceOf(ExpenseTransaction::class, $result);
        $this->assertEquals($user->getBalance()->getAmount(), 300);
    }

    public function testCanExecuteIncomeTransaction()
    {
        $user = UserFactory::create(
            $this->faker->firstName,
            $this->faker->lastName,
            $this->faker->email,
            $this->faker->password,
            $this->faker->currencyCode
        );
        $user->setBalance(Money::createForUser(500, $user));

        $income = IncomeFactory::create(
            $this->faker->words(4, true),
            $user,
            Money::createForUser(200, $user),
            Recurrence::createNonRecurrent(new DateTime())
        );

        $result = $this->transactionService->executeIncome($income);

        $this->assertInstanceOf(IncomeTransaction::class, $result);
        $this->assertEquals($user->getBalance()->getAmount(), 700);
    }
}
