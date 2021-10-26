<?php
declare(strict_types=1);

namespace App\Adapter\Http\Controller\Box;

use App\Infrastructure\Exception\InvalidRequest;

/**
 * This class is for validating schema of received data.
 */
class DeleteSchema
{
    /**
     * @param mixed $data
     * @return void
     * @throws InvalidRequest
     */
    public static function validate(mixed $data): void
    {
        if (!is_array($data)) {
            throw new InvalidRequest("Invalid data format");
        }

        if (!isset($data['identifier'])) {
            throw new InvalidRequest("Identifier must be given");
        }

        if (!is_string($data['identifier'])) {
            throw new InvalidRequest("Identifier must be string");
        }
    }
}