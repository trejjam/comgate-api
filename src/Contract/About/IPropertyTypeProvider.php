<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Contract\About;

interface IPropertyTypeProvider
{
    public function getType(object $contract, string $property) : string;
}
