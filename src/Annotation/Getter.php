<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Annotation;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\Common\Annotations\Annotation\Target;

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
