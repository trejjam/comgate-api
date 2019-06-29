<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Property;

/**
 * @method static XML()
 * @method static JSON()
 */
final class ResponseType extends AProperty
{
    public const XML = 'xml';
    public const JSON = 'json';
}
