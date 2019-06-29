<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Contract\About;

use Roave\BetterReflection\Reflection\ReflectionProperty;

final class PropertyTypeProvider implements IPropertyTypeProvider
{
    /**
     * @var string[][]
     */
    private $cache = [];

    public function getType(object $contract, string $property) : string
    {
        $cacheKey = get_class($contract);
        if (!array_key_exists($cacheKey, $this->cache)) {
            $this->cache[$cacheKey] = [];
        }

        if (!array_key_exists($property, $this->cache[$cacheKey])) {
            $propertyReflection = ReflectionProperty::createFromInstance($contract, $property);
            $type = $propertyReflection->getType();

            if ($type === null) {
                throw new \RuntimeException(); // TODO own exception
            }

            $this->cache[$cacheKey][$property] = $type->__toString();
        }

        return $this->cache[$cacheKey][$property];
    }
}
