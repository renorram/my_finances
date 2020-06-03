<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interfaces\CreatedAt;
use App\Entity\Interfaces\UpdatedAt;
use App\Entity\ValueObjects\Money;
use App\Entity\ValueObjects\Recurrence;
use DateTimeInterface;

class Expense implements CreatedAt, UpdatedAt
{
    private ?int $id;
    private User $user;
    private string $description;
    private Money $amount;
    private Recurrence $recurrence;
    private bool $paid;
    private DateTimeInterface $createdAt;
    private DateTimeInterface $updatedAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Expense
     */
    public function setUser(User $user): Expense
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Expense
     */
    public function setDescription(string $description): Expense
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Money
     */
    public function getAmount(): Money
    {
        return $this->amount;
    }

    /**
     * @param Money $amount
     * @return Expense
     */
    public function setAmount(Money $amount): Expense
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return Recurrence
     */
    public function getRecurrence(): Recurrence
    {
        return $this->recurrence;
    }

    /**
     * @param Recurrence $recurrence
     * @return Expense
     */
    public function setRecurrence(Recurrence $recurrence): Expense
    {
        $this->recurrence = $recurrence;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->paid;
    }

    /**
     * @param bool $paid
     * @return Expense
     */
    public function setPaid(bool $paid): Expense
    {
        $this->paid = $paid;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface $updatedAt
     * @return $this
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
