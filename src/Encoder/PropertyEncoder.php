<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Encoder;

use Trejjam\ComgateApi\Property\AProperty;

final class PropertyEncoder implements IPropertyEncoder
{
    public function isApplicable(string $type) : bool
    {
        return is_a($type, AProperty::class, true);
    }

    public function encode($value) : string
    {
        if (!($value instanceof AProperty)) {
            throw new \RuntimeException; //TODO own exception
        }

        return $value->getValue();
    }
}
