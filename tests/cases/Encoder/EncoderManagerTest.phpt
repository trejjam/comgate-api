<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Tests\Encoder;

use Composer;
use Doctrine\Common\Annotations\AnnotationReader;
use Tester;
use Tester\Assert;
use Trejjam\ComgateApi\Configuration\Integration;
use Trejjam\ComgateApi\Contract\About\PropertiesProvider;
use Trejjam\ComgateApi\Contract\About\PropertyTypeProvider;
use Trejjam\ComgateApi\Contract\Create;
use Trejjam\ComgateApi\Contract\Method;
use Trejjam\ComgateApi\Encoder\BoolEncoder;
use Trejjam\ComgateApi\Encoder\EncoderManager;
use Trejjam\ComgateApi\Encoder\IntEncoder;
use Trejjam\ComgateApi\Encoder\PropertyEncoder;
use Trejjam\ComgateApi\Tests\AnnotationHelper;

require __DIR__ . '/../../bootstrap.php';

class EncoderManagerTest extends Tester\TestCase
{
    /**
     * @var EncoderManager
     */
    private $encoderManager;

    protected function setUp()
    {
        AnnotationHelper::loadCustomAnnotations();

        $annotationReader = new AnnotationReader;
        $propertiesProvider = new PropertiesProvider(
            $annotationReader
        );

        $this->encoderManager = new EncoderManager(
            $propertiesProvider,
            new PropertyTypeProvider,
            [
                new BoolEncoder,
                new IntEncoder,
                new PropertyEncoder,
            ]
        );
    }

    public function testCreateContract()
    {
        $create = $this->createCreateContract();

        $encodedContract = $this->encoderManager->encode($create);

        Assert::same(
            [
                'merchant' => '<merchant>',
                'test'     => 'true',
                'price'    => '0',
                'curr'     => 'CZK',
                'label'    => '',
                'refId'    => '',
                'method'   => '',
                'email'    => '',
            ],
            $encodedContract
        );
    }

    public function testMethodContract()
    {
        $method = $this->createMethodContract();

        $encodedContract = $this->encoderManager->encode($method);

        Assert::same(
            [
                'merchant' => '<merchant>',
                'secret'   => '<secret>',
            ],
            $encodedContract
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

$test = new EncoderManagerTest;
$test->run();
