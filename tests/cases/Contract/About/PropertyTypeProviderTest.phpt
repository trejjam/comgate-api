<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Tests\Contract\About;

use Composer;
use Tester;
use Tester\Assert;
use Trejjam\ComgateApi\Configuration\Integration;
use Trejjam\ComgateApi\Contract\About\PropertyTypeProvider;
use Trejjam\ComgateApi\Contract\Create;
use Trejjam\ComgateApi\Contract\Method;
use Trejjam\ComgateApi\Property\Country;
use Trejjam\ComgateApi\Property\Language;
use Trejjam\ComgateApi\Property\ResponseType;

require __DIR__ . '/../../../bootstrap.php';

class PropertyTypeProviderTest extends Tester\TestCase
{
    /**
     * @var PropertyTypeProvider
     */
    private $propertyTypeProvider;

    protected function setUp()
    {
        $this->propertyTypeProvider = new PropertyTypeProvider;
    }

    public function testCreateContract()
    {
        $createContract = $this->createCreateContract();

        Assert::same(['string'], $this->propertyTypeProvider->getTypes($createContract, 'merchant'));
        Assert::same(['bool', 'null'], $this->propertyTypeProvider->getTypes($createContract, 'test'));
        Assert::same(
            ['\\' . Country::class, 'null'],
            $this->propertyTypeProvider->getTypes($createContract, 'country')
        );
        Assert::same(['int'], $this->propertyTypeProvider->getTypes($createContract, 'price'));
        Assert::same(['string'], $this->propertyTypeProvider->getTypes($createContract, 'curr'));
        Assert::same(['string'], $this->propertyTypeProvider->getTypes($createContract, 'label'));
        Assert::same(['string'], $this->propertyTypeProvider->getTypes($createContract, 'refId'));
        Assert::same(['string', 'null'], $this->propertyTypeProvider->getTypes($createContract, 'payerId'));
        Assert::same(['string'], $this->propertyTypeProvider->getTypes($createContract, 'method'));
        Assert::same(['string', 'null'], $this->propertyTypeProvider->getTypes($createContract, 'account'));
        Assert::same(['string'], $this->propertyTypeProvider->getTypes($createContract, 'email'));
        Assert::same(['string', 'null'], $this->propertyTypeProvider->getTypes($createContract, 'phone'));
        Assert::same(['string', 'null'], $this->propertyTypeProvider->getTypes($createContract, 'name'));
        Assert::same(['string', 'null'], $this->propertyTypeProvider->getTypes($createContract, 'lang'));
        Assert::same(['bool', 'null'], $this->propertyTypeProvider->getTypes($createContract, 'prepareOnly'));
        Assert::same(['string', 'null'], $this->propertyTypeProvider->getTypes($createContract, 'secret'));
        Assert::same(['bool', 'null'], $this->propertyTypeProvider->getTypes($createContract, 'preauth'));
        Assert::same(['bool', 'null'], $this->propertyTypeProvider->getTypes($createContract, 'initRecurring'));
        Assert::same(['bool', 'null'], $this->propertyTypeProvider->getTypes($createContract, 'verification'));
        Assert::same(['bool', 'null'], $this->propertyTypeProvider->getTypes($createContract, 'embedded'));
        Assert::same(['bool', 'null'], $this->propertyTypeProvider->getTypes($createContract, 'eetReport'));
        Assert::same(['object', 'null'], $this->propertyTypeProvider->getTypes($createContract, 'eetData'));
    }

    public function testMethodContract()
    {
        $methodContract = $this->createMethodContract();

        Assert::same(['string'], $this->propertyTypeProvider->getTypes($methodContract, 'merchant'));
        Assert::same(['string'], $this->propertyTypeProvider->getTypes($methodContract, 'secret'));
        Assert::same(
            ['\\' . ResponseType::class, 'null'],
            $this->propertyTypeProvider->getTypes($methodContract, 'type')
        );
        Assert::same(
            ['\\' . Language::class, 'null'],
            $this->propertyTypeProvider->getTypes($methodContract, 'lang')
        );
        Assert::same(['string', 'null'], $this->propertyTypeProvider->getTypes($methodContract, 'curr'));
        Assert::same(
            ['\\' . Country::class, 'null'],
            $this->propertyTypeProvider->getTypes($methodContract, 'country')
        );
    }

    private function createCreateContract() : Create
    {
        return new Create(
            $this->createIntegration(),
            0,
            'CZK',
            '',
            '',
            '',
            ''
        );
    }

    private function createMethodContract() : Method
    {
        return new Method(
            $this->createIntegration()
        );
    }

    private function createIntegration() : Integration
    {
        return new Integration(
            'https://payments.comgate.cz',
            'v1.0',
            '<merchant>',
            '<secret>',
            true
        );
    }
}

$test = new PropertyTypeProviderTest;
$test->run();
