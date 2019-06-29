<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Contract\About;

interface IPropertiesProvider
{
    public function getProperties(object $contract) : array;
}
