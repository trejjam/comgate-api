<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Contract\About;

interface IPropertyTypeProvider
{
    public function getTypes(object $contract, string $property) : array;
}
