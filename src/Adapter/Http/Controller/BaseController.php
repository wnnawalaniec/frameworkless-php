<?php
declare(strict_types=1);

namespace App\Adapter\Http\Controller;

use App\Adapter\Http\Helper\ResponseHelper;
use Psr\Http\Message\ResponseInterface;

/**
 * Base abstraction for all HTTP controllers.
 */
abstract class BaseController
{
    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public static function return404(ResponseInterface $response): ResponseInterface
    {
        return self::returnError($response, 404, 'NOT_FOUND');
    }

    /**
     * @param ResponseInterface $response
     * @param int $status
     * @param string $code
     * @return ResponseInterface
     */
    public static function returnError(ResponseInterface $response, int $status, string $code): ResponseInterface
    {
        $response = $response->withStatus($status);
        return ResponseHelper::json($response, ['error_code' => $code]);
    }

    /**
     * @param ResponseInterface $response
     * @param string $code
     * @return ResponseInterface
     */
    public static function return400(ResponseInterface $response, string $code = "BAR_REQUEST"): ResponseInterface
    {
        return self::returnError($response, 400, $code);
    }

    /**
     * @param ResponseInterface $response
     * @param $json
     * @return ResponseInterface
     */
    public static function return201(ResponseInterface $response, $json = []): ResponseInterface
    {
        return ResponseHelper::json($response->withStatus(201), $json);
    }

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public static function return204(ResponseInterface $response): ResponseInterface
    {
        return ResponseHelper::json($response->withStatus(204));
    }
}