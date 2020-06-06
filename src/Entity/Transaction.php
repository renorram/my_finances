<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interfaces\CreatedAt;
use App\Entity\Interfaces\UpdatedAt;
use DateTimeInterface;

abstract class Transaction implements CreatedAt, UpdatedAt
{
    private ?int $id;
    private string $description;
    private DateTimeInterface $createdAt;
    private DateTimeInterface $updatedAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    abstract public function getType(): string;

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Transaction
     */
    public function setDescription(string $description): Transaction
    {
        $this->description = $description;

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
    public function setCreatedAt(DateTimeInterface $createdAt): Transaction
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
    public function setUpdatedAt(DateTimeInterface $updatedAt): Transaction
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
