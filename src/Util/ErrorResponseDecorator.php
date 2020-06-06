<?php declare(strict_types=1);

namespace App\Util;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\ORMException;
use Throwable;

final class ErrorResponseDecorator
{
    public static function decorateException(Throwable $exception): array
    {
        $message = $exception instanceof ORMException || $exception instanceof DBALException ? "An internal error occurred." : $exception->getMessage();

        return [
            'error' => $message
        ];
    }
}
