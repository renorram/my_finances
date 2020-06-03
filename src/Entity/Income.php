<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interfaces\CreatedAt;
use App\Entity\Interfaces\UpdatedAt;
use App\Entity\ValueObjects\Money;
use App\Entity\ValueObjects\Recurrence;
use DateTimeInterface;

class Income implements CreatedAt, UpdatedAt
{
    private ?int $id;
    private User $user;
    private string $description;
    private Money $amount;
    private Recurrence $recurrence;
    private bool $received;
    private DateTimeInterface $createdAt;
    private DateTimeInterface $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Income
    {
        $this->user = $user;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Income
    {
        $this->description = $description;

        return $this;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function setAmount(Money $amount): Income
    {
        $this->amount = $amount;

        return $this;
    }

    public function getRecurrence(): Recurrence
    {
        return $this->recurrence;
    }

    public function setRecurrence(Recurrence $recurrence): Income
    {
        $this->recurrence = $recurrence;

        return $this;
    }

    public function isReceived(): bool
    {
        return $this->received;
    }

    public function setReceived(bool $received): Income
    {
        $this->received = $received;

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
