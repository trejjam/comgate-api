<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class Getter
{
    /**
     * @Required
     * @var string
     */
    public $getterName;
}
