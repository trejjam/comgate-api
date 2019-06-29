<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Encoder;

interface IPropertyEncoder
{
    public function isApplicable(string $type) : bool;

    /**
     * @param mixed $value
     */
    public function encode($value) : string;
}
