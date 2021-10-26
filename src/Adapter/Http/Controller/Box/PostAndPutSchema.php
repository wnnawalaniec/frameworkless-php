<?php
declare(strict_types=1);

namespace App\Adapter\Http\Controller\Box;

use App\Infrastructure\Exception\InvalidRequest;

/**
 * This class is for validating schema of received data.
 */
class PostAndPutSchema
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

        if (!isset($data['name'])) {
            throw new InvalidRequest("Name must be given");
        }

        if (!isset($data['capacity'])) {
            throw new InvalidRequest("Capacity must be given");
        }

        if (!is_integer($data['capacity'])) {
            throw new InvalidRequest("Capacity must be integer");
        }

        if (!is_string($data['name'])) {
            throw new InvalidRequest("Name must be string");
        }
    }
}