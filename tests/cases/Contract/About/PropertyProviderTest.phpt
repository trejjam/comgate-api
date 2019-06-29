<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Tests\Contract\About;

use Composer;
use Doctrine\Common\Annotations\AnnotationReader;
use Tester;
use Tester\Assert;
use Trejjam\ComgateApi\Configuration\Integration;
use Trejjam\ComgateApi\Contract\About\PropertiesProvider;
use Trejjam\ComgateApi\Contract\Create;
use Trejjam\ComgateApi\Contract\Method;
use Trejjam\ComgateApi\Tests\AnnotationHelper;

require __DIR__ . '/../../../bootstrap.php';

class PropertyProviderTest extends Tester\TestCase
{
    /**
     * @var PropertiesProvider
     */
    private $propertiesProvider;

    protected function setUp()
    {
        AnnotationHelper::loadCustomAnnotations();

        $annotationReader = new AnnotationReader;
        $this->propertiesProvider = new PropertiesProvider(
            $annotationReader
        );
    }

    public function testCreateContract()
    {
        $createContract = $this->createCreateContract();

        $properties = $this->propertiesProvider->getProperties($createContract);

        Assert::same([
            'merchant'      => 'getMerchant',
            'test'          => 'getTest',
            'country'       => 'getCountry',
            'price'         => 'getPrice',
            'curr'          => 'getCurrency',
            'label'         => 'getLabel',
            'refId'         => 'getRefId',
            'payerId'       => 'getPayerId',
            'method'        => 'getMethod',
            'account'       => 'getAccount',
            'email'         => 'getEmail',
            'phone'         => 'getPhone',
            'name'          => 'getName',
            'lang'          => 'getLanguage',
            'prepareOnly'   => 'getPrepareOnly',
            'secret'        => 'getSecret',
            'preauth'       => 'getPreauth',
            'initRecurring' => 'getInitRecurring',
            'verification'  => 'getVerification',
            'embedded'      => 'getEmbedded',
            'eetReport'     => 'getEetReport',
            'eetData'       => 'getEetData',
        ], $properties);
    }

    public function testMethodContract()
    {
        $methodContract = $this->createMethodContract();

        $properties = $this->propertiesProvider->getProperties($methodContract);

        Assert::same([
            'merchant' => 'getMerchant',
            'secret'   => 'getSecret',
            'type'     => 'getType',
            'lang'     => 'getLanguage',
            'curr'     => 'getCurrency',
            'country'  => 'getCountry',
        ], $properties);
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

$test = new PropertyProviderTest;
$test->run();
