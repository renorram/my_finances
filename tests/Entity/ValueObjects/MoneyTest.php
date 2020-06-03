<?php

declare(strict_types=1);

namespace App\Tests\Entity\ValueObjects;

use App\Entity\ValueObjects\Money;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function testMoneySum()
    {
        $firstValue = Money::newFromValueAndCurrency(100, 'USD');
        $secondValue = Money::newFromValueAndCurrency(100, 'USD');

        $finalValue = $firstValue->add($secondValue);
        $this->assertInstanceOf(Money::class, $finalValue);
        $this->assertEquals( 200, $finalValue->getAmount());
    }

    public function testMoneySubtract()
    {
        $firstValue = Money::newFromValueAndCurrency(200, 'USD');
        $secondValue = Money::newFromValueAndCurrency(100, 'USD');

        $finalValue = $firstValue->subtract($secondValue);
        $this->assertInstanceOf(Money::class, $finalValue);
        $this->assertEquals( 100, $finalValue->getAmount());
    }

    public function testMoneyMultiply()
    {
        $firstValue = Money::newFromValueAndCurrency(100, 'USD');

        $finalValue = $firstValue->multiply(2);
        $this->assertInstanceOf(Money::class, $finalValue);
        $this->assertEquals( 200, $finalValue->getAmount());
    }

    public function testMoneyDivisor()
    {
        $firstValue = Money::newFromValueAndCurrency(100, 'USD');

        $finalValue = $firstValue->divide(2);
        $this->assertInstanceOf(Money::class, $finalValue);
        $this->assertEquals( 50, $finalValue->getAmount());
    }

    /**
     * @dataProvider invalidCurrencyDataProvider
     * @param string $invalidCurrency
     */
    public function testFailCreateInstaceWithInvalidCurrency(string $invalidCurrency)
    {
        $this->expectException(InvalidArgumentException::class);
        Money::newFromValueAndCurrency(200, $invalidCurrency);
    }

    public function invalidCurrencyDataProvider()
    {
        return [
            ['a'],
            ['1213'],
            ['aaa'],
            ['x'],
        ];
    }
}
