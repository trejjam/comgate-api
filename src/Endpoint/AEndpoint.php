<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Endpoint;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\RequestOptions;
use Trejjam\ComgateApi\Configuration\Integration;
use Trejjam\ComgateApi\Encoder\EncoderManager;

class AEndpoint
{
    protected const URL_PATH = '<missing>';

    /**
     * @var string
     */
    private $url;

    /**
     * @var Integration
     */
    private $integration;
    /**
     * @var Client
     */
    private $httpClient;
    /**
     * @var EncoderManager
     */
    private $encoderManager;

    public function __construct(
        Integration $integration,
        Client $httpClient,
        EncoderManager $encoderManager
    ) {
        $this->integration = $integration;
        $this->httpClient = $httpClient;
        $this->encoderManager = $encoderManager;
    }

    protected function doRequest(object $contract) : PromiseInterface
    {
        $encodedData = $this->encoderManager->encode($contract);

        return $this->httpClient->postAsync($this->getUrl(), [
            RequestOptions::FORM_PARAMS => $encodedData,
        ]);
    }

    protected function getUrl() : string
    {
        return $this->url ?? $this->url = implode(
            '/',
            [
                $this->integration->getApiServer(),
                $this->integration->getApiVersion(),
                static::URL_PATH,
            ]
        );
    }
}
