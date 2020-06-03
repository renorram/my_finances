<?php declare(strict_types=1);

namespace App\Entity\Interfaces;

use DateTimeInterface;

interface CreatedAt
{
    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface;

    /**
     * @param DateTimeInterface $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTimeInterface $createdAt): self;
}
