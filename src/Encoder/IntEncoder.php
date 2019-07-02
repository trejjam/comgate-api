<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Encoder;

final class IntEncoder implements IPropertyEncoder
{
    public function isApplicable(string $type) : bool
    {
        return $type === 'int';
    }

    public function encode($value) : string
    {
        if (!is_int($value)) {
            throw new \RuntimeException; //TODO own exception
        }

        return sprintf("%d", $value);
    }
}
