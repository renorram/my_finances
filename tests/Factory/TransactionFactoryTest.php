<?php declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Expense;
use App\Entity\ExpenseTransaction;
use App\Entity\Income;
use App\Entity\IncomeTransaction;
use App\Factory\TransactionFactory;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

class TransactionFactoryTest extends TestCase
{
    public function testCanCreateExpenseTransaction()
    {
        $expense = $this->createStub(Expense::class);
        $transaction = TransactionFactory::create($expense);

        $this->assertInstanceOf(ExpenseTransaction::class, $transaction);
    }

    public function testCanCreateIncomeTransaction()
    {
        $income = $this->createStub(Income::class);
        $transaction = TransactionFactory::create($income);

        $this->assertInstanceOf(IncomeTransaction::class, $transaction);
    }

    public function testShouldFailWithInvalidType()
    {
        $this->expectException(InvalidArgumentException::class);

        $class = new stdClass();
        $transaction = TransactionFactory::create($class);
    }
}
