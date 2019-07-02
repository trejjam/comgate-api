<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Encoder;

use Closure;
use Trejjam\ComgateApi\Contract\About\IPropertiesProvider;
use Trejjam\ComgateApi\Contract\About\IPropertyTypeProvider;
use function Safe\sprintf;

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
    private $propertyEncoders;

    /**
     * @param IPropertyEncoder[] $propertyEncoders
     */
    public function __construct(
        IPropertiesProvider $propertiesProvider,
        IPropertyTypeProvider $propertyTypeProvider,
        array $propertyEncoders
    ) {
        $this->propertiesProvider = $propertiesProvider;
        $this->propertyTypeProvider = $propertyTypeProvider;
        $this->propertyEncoders = $propertyEncoders;
    }


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
        $value = Closure::fromCallable([$contract, $propertyGetter])->call($contract);

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

        if (is_string($value)) {
            return $value;
        }

        throw new \RuntimeException(sprintf("Unable to encode value from %s of type %s", $propertyGetter, implode(' | ', $propertyTypes)));
    }
}
