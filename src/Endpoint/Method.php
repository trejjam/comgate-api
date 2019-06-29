<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Endpoint;

use GuzzleHttp\Promise\PromiseInterface;
use Trejjam\ComgateApi\Contract\Method as MethodContract;

final class Method extends AEndpoint
{
    protected const URL_PATH = 'methods';

    public function getMethods(MethodContract $method) : PromiseInterface
    {
        return $this->doRequest($method);
    }
}
