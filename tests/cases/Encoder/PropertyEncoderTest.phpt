<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Tests\Encoder;

use Composer;
use Tester;
use Tester\Assert;
use Trejjam\ComgateApi\Encoder\PropertyEncoder;
use Trejjam\ComgateApi\Property\Country;
use Trejjam\ComgateApi\Property\Language;
use Trejjam\ComgateApi\Property\ResponseType;

require __DIR__ . '/../../bootstrap.php';

class PropertyEncoderTest extends Tester\TestCase
{
    /**
     * @var PropertyEncoder
     */
    private $propertyEncoder;

    protected function setUp()
    {
        $this->propertyEncoder = new PropertyEncoder;
    }

    public function testCountryType()
    {
        Assert::true($this->propertyEncoder->isApplicable(Country::class));
        Assert::false($this->propertyEncoder->isApplicable('string'));

        Assert::same('CZ', $this->propertyEncoder->encode(Country::CZ()));
        Assert::same('SK', $this->propertyEncoder->encode(Country::SK()));
        Assert::same('PL', $this->propertyEncoder->encode(Country::PL()));
        Assert::same('ALL', $this->propertyEncoder->encode(Country::ALL()));
    }

    public function testLanguageType()
    {
        Assert::true($this->propertyEncoder->isApplicable(Language::class));
        Assert::false($this->propertyEncoder->isApplicable('string'));

        Assert::same('cs', $this->propertyEncoder->encode(Language::CS()));
        Assert::same('sk', $this->propertyEncoder->encode(Language::SK()));
        Assert::same('en', $this->propertyEncoder->encode(Language::EN()));
    }

    public function testResponseTypeType()
    {
        Assert::true($this->propertyEncoder->isApplicable(ResponseType::class));
        Assert::false($this->propertyEncoder->isApplicable('string'));

        Assert::same('xml', $this->propertyEncoder->encode(ResponseType::XML()));
        Assert::same('json', $this->propertyEncoder->encode(ResponseType::JSON()));
    }
}

$test = new PropertyEncoderTest;
$test->run();
