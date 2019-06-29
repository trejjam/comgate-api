<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Tests;

use Trejjam\ComgateApi\Annotation\Getter;

final class AnnotationHelper
{
    public static function loadCustomAnnotations() : void
    {
        new Getter;
    }
}
