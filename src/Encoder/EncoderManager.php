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
            $propertyTypes = $this->propertyTypeProvider->getTypes($contract, $property);
            $encodedValue = $this->encodeValue($contract, $propertyGetter, $propertyTypes);

            if ($encodedValue !== null) {
                $encodedValues[$property] = $encodedValue;
            }
        }

        return $encodedValues;
    }

    private function encodeValue(object $contract, string $propertyGetter, array $propertyTypes) : ?string
    {
        $value = call_user_method($propertyGetter, $contract);

        if ($value === null) {
            return $value;
        }

        foreach ($this->propertyEncoders as $propertyEncoder) {
            foreach ($propertyTypes as $propertyType) {
                if ($propertyEncoder->isApplicable($propertyType)) {
                    return $propertyEncoder->encode($value);
                }
            }
        }
    }
}
