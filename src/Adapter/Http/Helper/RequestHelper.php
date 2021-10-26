<?php
declare(strict_types=1);

namespace App\Adapter\Http\Helper;

use App\Infrastructure\Exception\InvalidRequest;
use Psr\Http\Message\RequestInterface;

/**
 * Class with static methods helping in some common HTTP based
 * actions involving requests.
 */
class RequestHelper
{
    /**
     * @param RequestInterface $request
     * @param bool $asArray
     * @return mixed
     * @throws InvalidRequest
     */
    public static function parseJson(RequestInterface $request, bool $asArray = false): mixed
    {
        if (!$request->hasHeader('Content-Type')) {
            throw InvalidRequest::wrongContentType();
        }

        if ($request->getHeader('Content-Type')[0] !== 'application/json') {
            throw InvalidRequest::wrongContentType();
        }

        $json = (string)$request->getBody();

        return json_decode($json, $asArray);
    }
}