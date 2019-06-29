<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Configuration;

final class Integration
{
    /**
     * @var string
     */
    private $apiServer;
    /**
     * @var string
     */
    private $apiVersion;
    /**
     * @var string
     */
    private $merchant;
    /**
     * @var string
     */
    private $secret;
    /**
     * @var bool
     */
    private $testEnvironment;

    public function __construct(
        string $apiServer,
        string $apiVersion,
        string $merchant,
        string $secret,
        bool $testEnvironment
    ) {
        $this->apiServer = $apiServer;
        $this->apiVersion = $apiVersion;
        $this->merchant = $merchant;
        $this->secret = $secret;
        $this->testEnvironment = $testEnvironment;
    }

    public function getApiServer() : string
    {
        return $this->apiServer;
    }

    public function getApiVersion() : string
    {
        return $this->apiVersion;
    }

    public function getMerchant() : string
    {
        return $this->merchant;
    }

    public function getSecret() : string
    {
        return $this->secret;
    }

    public function isTestEnvironment() : bool
    {
        return $this->testEnvironment;
    }

}
