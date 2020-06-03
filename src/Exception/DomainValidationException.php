<?php

namespace App\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class DomainValidationException extends Exception
{
    private ConstraintViolationListInterface $constraintViolationList;

    public function __construct(ConstraintViolationListInterface $constraintViolationList, $code = 0, Throwable $previous = null)
    {
        $this->constraintViolationList = $constraintViolationList;
        parent::__construct($this->getMessageFromViolations(), $code, $previous);
    }

    private function getMessageFromViolations(): string
    {
        return (string)$this->constraintViolationList;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getConstraintViolationList(): ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }
}