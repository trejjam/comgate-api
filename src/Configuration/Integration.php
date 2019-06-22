<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Configuration;

final class Integration
{
    /**
     * @var string
     */
    private $merchant;

    public function __construct(string $merchant)
    {
        $this->merchant = $merchant;
    }

    public function getMerchant() : string
    {
        return $this->merchant;
    }
}
