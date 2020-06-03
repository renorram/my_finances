<?php

declare(strict_types=1);

namespace App\Entity\ValueObjects;

use DateTimeInterface;
use InvalidArgumentException;
use function in_array;
use function is_null;
use function sprintf;

final class Recurrence
{
    const TYPE_NONE = 'none';
    const TYPE_REPEATABLE = 'repeatable';
    const TYPE_RECURRENT = 'recurrent';
    const TYPE_LIST = [
        self::TYPE_NONE       => 'none',
        self::TYPE_REPEATABLE => 'repeatable',
        self::TYPE_RECURRENT  => 'recurrent',
    ];
    private string $type;
    private DateTimeInterface $dueDate;
    private ?int $installments;

    /**
     * Recurrence constructor.
     *
     * @param string $type
     * @param DateTimeInterface $dueDate
     * @param int|null $installments
     */
    public function __construct(string $type, DateTimeInterface $dueDate, ?int $installments = null)
    {
        if (!in_array($type, self::TYPE_LIST)) {
            throw new InvalidArgumentException(sprintf('%s not a valid recurrence type.', $type));
        }

        if (!is_null($installments) && $installments < 1) {
            throw new InvalidArgumentException(sprintf('Installments can not be 0 or a negative value.'));
        }

        if ($type === self::TYPE_REPEATABLE && is_null($installments)) {
            throw new InvalidArgumentException(sprintf('Repeatable recurrencies must have an installment value.'));
        }

        if (($type === self::TYPE_RECURRENT || $type === self::TYPE_NONE) && !is_null($installments)) {
            throw new InvalidArgumentException(sprintf('Only repeatable recurrencies can have an installment value.'));
        }

        $this->type = $type;
        $this->dueDate = $dueDate;
        $this->installments = $installments;
    }

    public static function createNonRecurrent(DateTimeInterface $dueDate): self
    {
        return new self(self::TYPE_NONE, $dueDate);
    }

    public static function createRepeatable(DateTimeInterface $dueDate, int $installments = 0)
    {
        return new self(self::TYPE_REPEATABLE, $dueDate, $installments);
    }

    public static function createRecurrent(DateTimeInterface $dueDate)
    {
        return new self(self::TYPE_RECURRENT, $dueDate);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDueDate(): DateTimeInterface
    {
        return $this->dueDate;
    }

    public function getInstallments(): ?int
    {
        return $this->installments;
    }
}
