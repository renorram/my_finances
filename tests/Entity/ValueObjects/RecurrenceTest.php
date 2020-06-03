<?php

namespace App\Tests\Entity\ValueObjects;

use DateTime;
use Faker\Factory as FakerFactory;
use App\Entity\ValueObjects\Recurrence;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RecurrenceTest extends TestCase
{
    public function testCreateRecurrencyRepeatable()
    {
        $now = new DateTime();
        $recurrence = Recurrence::createRepeatable($now, 10);
        $this->assertEquals(10, $recurrence->getInstallments());
        $this->assertEquals(Recurrence::TYPE_REPEATABLE, $recurrence->getType());
        $this->assertEquals($now, $recurrence->getDueDate());
    }

    public function testCreateRecurrencyNone()
    {
        $now = new DateTime();
        $recurrence = Recurrence::createNonRecurrent($now);
        $this->assertNull($recurrence->getInstallments());
        $this->assertEquals(Recurrence::TYPE_NONE, $recurrence->getType());
        $this->assertEquals($now, $recurrence->getDueDate());
    }

    public function testCreateRecurrencyRecurrent()
    {
        $now = new DateTime();
        $recurrence = Recurrence::createRecurrent($now);
        $this->assertNull($recurrence->getInstallments());
        $this->assertEquals(Recurrence::TYPE_RECURRENT, $recurrence->getType());
        $this->assertEquals($now, $recurrence->getDueDate());
    }

    /**
     * @dataProvider invalidDataProvider
     * @param $text
     * @param $date
     * @param $installments
     */
    public function testFailCreationWithInvalidType($text, $date, $installments)
    {
        $this->expectException(InvalidArgumentException::class);
        new Recurrence($text, $date, $installments);
    }

    public function testFailCreatRecurrentWithInstallmentValue()
    {
        $this->expectException(InvalidArgumentException::class);
        new Recurrence(Recurrence::TYPE_RECURRENT, new DateTime(), 10);
    }

    public function testFailCreateRepeatableWithoutInstallmentValue()
    {
        $this->expectException(InvalidArgumentException::class);
        new Recurrence(Recurrence::TYPE_REPEATABLE, new DateTime());
    }

    public function invalidDataProvider()
    {
        $faker = FakerFactory::create();
        return [
            [$faker->text, $faker->dateTime, $faker->numberBetween(-10, 0)],
            [$faker->text, $faker->dateTime, $faker->randomDigitNotNull],
            [$faker->text, $faker->dateTime, null]
        ];
    }
}