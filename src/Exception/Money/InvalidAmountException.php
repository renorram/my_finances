<?php

declare(strict_types=1);

namespace App\Exception\Money;

use InvalidArgumentException;
use Throwable;

class InvalidAmountException extends InvalidArgumentException
{
    public function __construct(int $amount, $code = 0, Throwable $previous = null)
    {
        $message = sprintf('%d is not a valid amount, negative values are not allowed.', $amount);
        parent::__construct($message, $code, $previous);
    }
}
