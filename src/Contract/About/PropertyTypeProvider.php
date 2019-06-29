<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Contract\About;

use Roave\BetterReflection\Reflection\ReflectionProperty;

final class PropertyTypeProvider implements IPropertyTypeProvider
{
    /**
     * @var string[][][]
     */
    private $cache = [];

    public function getTypes(object $contract, string $property) : array
    {
        $cacheKey = get_class($contract);
        if (!array_key_exists($cacheKey, $this->cache)) {
            $this->cache[$cacheKey] = [];
        }

        if (!array_key_exists($property, $this->cache[$cacheKey])) {
            $propertyReflection = ReflectionProperty::createFromInstance($contract, $property);
            $type = $propertyReflection->getType();

            if ($type === null) {
                $types = [];
                foreach ($propertyReflection->getDocBlockTypes() as $_type) {
                    $types[] = $_type->__toString();
                }
            }
            else {
                $types = [$type->__toString()];
            }

            if (count($types) === 0) {
                throw new \RuntimeException; // TODO own exception
            }

            $this->cache[$cacheKey][$property] = $types;
        }

        return $this->cache[$cacheKey][$property];
    }
}
