<?php

declare(strict_types=1);

namespace App\Entity\Interfaces;

/**
 * Interface to represent monetary values based on the Money pattern.
 *
 * @see https://www.martinfowler.com/eaaCatalog/money.html
 * @see https://github.com/moneyphp/money
 *
 * Interface Money
 */
interface Money
{
    /**
     * Money constructor.
     * Should validate if the currency is a valid 3 uppercase letter string.
     *
     * @param int $amount
     * @param string $currency
     */
    public function __construct(int $amount, string $currency);

    /**
     * Should return the amount in cents.
     */
    public function getAmount(): int;

    /**
     * Should return a 3 uppercase letter string represent the currency value.
     */
    public function getCurrency(): string;

    /**
     * Add the $money value to the current instance returning a new Money instance with the result.
     *
     * @param Money $money
     * @return Money
     */
    public function add(Money $money): Money;

    /**
     * Subtract the $money value to the current instance returning a new Money instance with the result.
     *
     * @param Money $money
     * @return Money
     */
    public function subtract(Money $money): Money;

    /**
     * Multiply the current instance by the $factor and return a new Money instance
     *
     * @param int $factor
     * @return Money
     */
    public function multiply(int $factor): Money;

    /**
     * Divide the current instance by the $divisor and return a new Money instance
     *
     * @param int $divisor
     * @return Money
     */
    public function divide(int $divisor): Money;
}
