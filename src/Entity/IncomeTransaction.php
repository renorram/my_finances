<?php declare(strict_types=1);

namespace App\Entity;

class IncomeTransaction extends Transaction
{
    const INCOME_TYPE = 'income';

    private Income $income;

    /**
     * @return Income
     */
    public function getIncome(): Income
    {
        return $this->income;
    }

    /**
     * @param Income $income
     * @return IncomeTransaction
     */
    public function setIncome(Income $income): IncomeTransaction
    {
        $this->income = $income;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::INCOME_TYPE;
    }
}
