<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Property;

use ReflectionClass;

abstract class AProperty
{
    /**
     * @var AProperty[][]
     */
    private static $dictionary = [];
    /**
     * @var string[][]
     */
    private static $reflectionDictionary = [];

    /**
     * @var string
     */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function __callStatic(string $name, array $arguments) : self
    {
        if (count($arguments) > 0) {
            throw new \InvalidArgumentException; //TODO own exception
        }

        if (static::class === self::class) {
            throw new \InvalidArgumentException; //TODO own exception
        }

        if (!array_key_exists(static::class, self::$dictionary)) {
            self::$dictionary[static::class] = [];
            self::$reflectionDictionary[static::class] = (new ReflectionClass(static::class))->getConstants();
        }

        if (!array_key_exists($name, self::$dictionary[static::class])) {
            if (!array_key_exists($name, self::$reflectionDictionary[static::class])) {
                throw new \InvalidArgumentException; //TODO own exception
            }

            self::$dictionary[static::class][$name] = new static(
                constant(static::class . '::' . $name)
            );
        }

        return self::$dictionary[static::class][$name];
    }

    public function getValue() : string
    {
        return $this->value;
    }
}
