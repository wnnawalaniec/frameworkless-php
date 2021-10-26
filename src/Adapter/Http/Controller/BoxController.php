<?php
declare(strict_types=1);

namespace App\Adapter\Http\Controller;

use App\Adapter\Http\Controller\Box\DeleteSchema;
use App\Adapter\Http\Controller\Box\PostAndPutSchema;
use App\Adapter\Http\Helper\RequestHelper;
use App\Adapter\Http\Helper\ResponseHelper;
use App\Application\Controller\BoxController as ApplicationController;
use App\Domain\Storage\Box\Exception\BoxNotFound;
use App\Domain\Storage\Box\Exception\NameIsEmpty;
use App\Domain\Storage\Box\Exception\NameTooLong;
use App\Domain\Storage\Box\Exception\NegativeCapacity;
use App\Infrastructure\Exception\InvalidRequest;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * HTTP controller for boxes.
 */
class BoxController extends BaseController
{
    /**
     * @param ApplicationController $controller
     */
    public function __construct(ApplicationController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param array $params
     * @return ResponseInterface
     */
    public function one(RequestInterface $request, ResponseInterface $response, array $params = []): ResponseInterface
    {
        if (!array_key_exists('identifier', $params)) {
            return self::return400($response, 'MISSING_PARAM');
        }

        try {
            $box = $this->controller->one($params['identifier']);
            return ResponseHelper::json($response, $box);
        } catch (BoxNotFound $e) {
            return self::return404($response);
        }
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function all(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return ResponseHelper::json(
            $response,
            $this->controller->all()
        );
    }

    /**
     * @throws InvalidRequest
     */
    public function add(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $box = RequestHelper::parseJson($request, true);
        PostAndPutSchema::validate($box);
        try {
            return self::return201($response, $this->controller->add($box));
        } catch (NameIsEmpty $e) {
            return self::return400($response, "NAME_IS_EMPTY");
        } catch (NameTooLong $e) {
            return self::return400($response, "NAME_IS_TOO_LONG");
        } catch (NegativeCapacity $e) {
            return self::return400($response, "NEGATIVE_CAPACITY");
        }
    }

    /**
     * @throws InvalidRequest
     */
    public function modify(
        RequestInterface $request,
        ResponseInterface $response,
        array $params = []): ResponseInterface
    {
        if (!array_key_exists('identifier', $params)) {
            return self::return400($response, 'MISSING_PARAM');
        }

        $json = RequestHelper::parseJson($request, true);
        PostAndPutSchema::validate($json);
        try {
            $this->controller->modify($params['identifier'], $json);
            return self::return204($response);
        } catch (NameIsEmpty $e) {
            return self::return400($response, "NAME_IS_EMPTY");
        } catch (NameTooLong $e) {
            return self::return400($response, "NAME_IS_TOO_LONG");
        } catch (NegativeCapacity $e) {
            return self::return400($response, "NEGATIVE_CAPACITY");
        } catch (BoxNotFound $e) {
            return self::return404($response);
        }
    }

    /**
     * @throws InvalidRequest
     */
    public function delete(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $json = RequestHelper::parseJson($request, true);
        DeleteSchema::validate($json);
        $this->controller->delete($json['identifier']);
        return self::return204($response);
    }
    /**
     * @var ApplicationController
     */
    private ApplicationController $controller;
}