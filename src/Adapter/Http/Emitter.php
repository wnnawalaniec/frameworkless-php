<?php
declare(strict_types=1);

namespace App\Adapter\Http;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface for emitting response from the application, back to the calling client.
 */
interface Emitter
{
    /**
     * @param ResponseInterface $response
     * @return void
     */
    public function emit(ResponseInterface $response): void;
}