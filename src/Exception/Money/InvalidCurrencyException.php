<?php

declare(strict_types=1);

namespace App\Exception\Money;

use InvalidArgumentException;
use Throwable;

class InvalidCurrencyException extends InvalidArgumentException
{
    public function __construct(string $currency, $code = 0, Throwable $previous = null)
    {
        $message = sprintf('%s is not a valid currency, must be a valid ISO 4217 currency code.', $currency);
        parent::__construct($message, $code, $previous);
    }
}
