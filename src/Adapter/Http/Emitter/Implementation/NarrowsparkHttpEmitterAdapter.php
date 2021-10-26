<?php
declare(strict_types=1);

namespace App\Adapter\Http\Emitter\Implementation;

use App\Adapter\Http\Emitter;
use Narrowspark\HttpEmitter\AbstractSapiEmitter;
use Psr\Http\Message\ResponseInterface;

/**
 * Example of Emitter implementation adapting some well-known, 3-rd party library.
 */
class NarrowsparkHttpEmitterAdapter implements Emitter
{
    /**
     * @param AbstractSapiEmitter $sapiEmitter
     */
    public function __construct(AbstractSapiEmitter $sapiEmitter)
    {
        $this->sapiEmitter = $sapiEmitter;
    }

    /**
     * @param ResponseInterface $response
     * @return void
     */
    public function emit(ResponseInterface $response): void
    {
        $this->sapiEmitter->emit($response);
    }
    /**
     * @var AbstractSapiEmitter
     */
    private AbstractSapiEmitter $sapiEmitter;
}