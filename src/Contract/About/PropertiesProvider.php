<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Contract\About;

use Doctrine\Common\Annotations\Reader;
use ReflectionClass;
use ReflectionProperty;
use Trejjam\ComgateApi\Annotation\Getter;

final class PropertiesProvider implements IPropertiesProvider
{
    /**
     * @var string[][]
     */
    private $cache = [];
    /**
     * @var Reader
     */
    private $annotationReader;

    public function __construct(
        Reader $annotationReader
    ) {
        $this->annotationReader = $annotationReader;
    }

    public function getProperties(object $contract) : array
    {
        $cacheKey = get_class($contract);
        if (!array_key_exists($cacheKey, $this->cache)) {
            $reflectionClass = new ReflectionClass($contract);

            $this->cache[$cacheKey] = [];
            foreach ($reflectionClass->getProperties(
                ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PUBLIC
            ) as $reflectionProperty) {
                $getter = 'get' . ucfirst($reflectionProperty->getName());

                /** @var Getter|null $getterAnnotation */
                $getterAnnotation = $this->annotationReader->getPropertyAnnotation(
                    $reflectionProperty,
                    Getter::class
                );

                if ($getterAnnotation !== null) {
                    $getter = $getterAnnotation->getterName;
                }

                $this->cache[$cacheKey][$reflectionProperty->getName()] = $getter;
            }
        }

        return $this->cache[$cacheKey];
    }
}
