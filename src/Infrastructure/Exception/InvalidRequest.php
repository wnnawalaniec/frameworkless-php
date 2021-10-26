<?php
declare(strict_types=1);

namespace App\Infrastructure\Exception;

class InvalidRequest extends InfrastructureException
{
    /**
     * @return static
     */
    public static function wrongContentType(): self
    {
        return new self("WRONG_CONTENT_TYPE");
    }

    /**
     * @return static
     */
    public static function invalidRequest(): self
    {
        return new self("INVALID_REQUEST");
    }
}