<?php declare(strict_types=1);

namespace App\Entity\Interfaces;

use DateTimeInterface;

interface UpdatedAt
{
    /**
     * @return DateTimeInterface
     */
    public function getUpdatedAt(): DateTimeInterface;

    /**
     * @param DateTimeInterface $updatedAt
     * @return $this
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): self;
}
