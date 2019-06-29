<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Encoder;

use Trejjam\ComgateApi\Contract\About\IPropertiesProvider;
use Trejjam\ComgateApi\Contract\About\IPropertyTypeProvider;

final class EncoderManager
{
    /**
     * @var IPropertiesProvider
     */
    private $propertiesProvider;

    /**
     * @var IPropertyTypeProvider
     */
    private $propertyTypeProvider;

    /**
     * @var IPropertyEncoder[]
     */
    private $propertyEncoders = [];

    /**
     * @param object $contract
     * @return string[]
     */
    public function encode(object $contract) : array
    {
        $properties = $this->propertiesProvider->getProperties($contract);

        $encodedValues = [];
        foreach ($properties as $property => $propertyGetter) {
            $propertyType = $this->propertyTypeProvider->getType($contract, $property);
            $encodedValue = $this->encodeValue($contract, $propertyGetter, $propertyType);

            if ($encodedValue !== null) {
                $encodedValues[$property] = $encodedValue;
            }
        }

        return $encodedValues;
    }

    private function encodeValue(object $contract, string $propertyGetter, string $propertyType) : ?string
    {
        $value = call_user_method($propertyGetter, $contract);

        if ($value === null) {
            return $value;
        }

        foreach ($this->propertyEncoders as $propertyEncoder) {
            if ($propertyEncoder->isApplicable($propertyType)) {
                return $propertyEncoder->encode($value);
            }
        }
    }
}
