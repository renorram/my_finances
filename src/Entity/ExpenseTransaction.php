<?php declare(strict_types=1);

namespace App\Entity;

class ExpenseTransaction extends Transaction
{
    const EXPENSE_TYPE = 'expense';

    private Expense $expense;

    /**
     * @return Expense
     */
    public function getExpense(): Expense
    {
        return $this->expense;
    }

    /**
     * @param Expense $expense
     * @return ExpenseTransaction
     */
    public function setExpense(Expense $expense): ExpenseTransaction
    {
        $this->expense = $expense;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::EXPENSE_TYPE;
    }
}
