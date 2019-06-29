<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Encoder;

final class BoolEncoder implements IPropertyEncoder
{
    public function isApplicable(string $type) : bool
    {
        return $type === 'bool';
    }

    public function encode($value) : string
    {
        if (!is_bool($value)) {
            throw new \RuntimeException(); //TODO own exception
        }

        return $value ? 'true' : 'false';
    }
}
