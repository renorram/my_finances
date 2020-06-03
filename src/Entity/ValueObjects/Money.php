<?php

declare(strict_types=1);

namespace App\Entity\ValueObjects;

use App\Entity\Interfaces\Money as MoneyInterface;
use App\Entity\User;
use App\Exception\Money\InvalidCurrencyException;
use InvalidArgumentException;
use JsonSerializable;
use Money\Currencies\ISOCurrencies;
use Money\Currency;

final class Money implements MoneyInterface, JsonSerializable
{
    private int $amount;
    private string $currency;
    private static ISOCurrencies $ISOCurrencies;

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public function __construct(int $amount, string $currency)
    {
        if (!isset(self::$ISOCurrencies)) {
            self::$ISOCurrencies = new ISOCurrencies();
        }

        self::validateCurrency($currency);

        $this->amount = $amount;
        $this->currency = $currency;
    }

    public static function validateCurrency(string $currency): bool
    {
        if (!isset(self::$ISOCurrencies)) {
            self::$ISOCurrencies = new ISOCurrencies();
        }

        if (!self::$ISOCurrencies->contains(new Currency($currency))) {
            throw new InvalidCurrencyException($currency);
        }

        return true;
    }

    public static function newFromValueAndCurrency(int $amount, string $currency)
    {
        return new self($amount, $currency);
    }

    public static function newFromMoneyInstance(\Money\Money $moneyInstance)
    {
        return self::newFromValueAndCurrency(
            (int) $moneyInstance->getAmount(),
            $moneyInstance->getCurrency()->getCode()
        );
    }

    public static function createForUser(int $amount, User $user): Money
    {
        return new self($amount, $user->getPreferredCurrency());
    }

    public function getMoneyInstance(): \Money\Money
    {
        return new \Money\Money($this->amount, new Currency($this->currency));
    }

    /**
     * {@inheritdoc}
     */
    public function add(MoneyInterface $money): Money
    {
        return self::newFromMoneyInstance(
            $this->getMoneyInstance()->add(
                new \Money\Money($money->getAmount(), new Currency($money->getCurrency()))
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function subtract(MoneyInterface $money): Money
    {
        return self::newFromMoneyInstance(
            $this->getMoneyInstance()->subtract(
                new \Money\Money($money->getAmount(), new Currency($money->getCurrency()))
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function multiply(int $factor): Money
    {
        return self::newFromMoneyInstance($this->getMoneyInstance()->multiply($factor));
    }

    /**
     * {@inheritdoc}
     */
    public function divide(int $divisor): Money
    {
        return self::newFromMoneyInstance($this->getMoneyInstance()->divide($divisor));
    }

    /**
     * {@inheritdoc}
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'amount'   => $this->amount,
            'currency' => $this->currency,
        ];
    }
}
