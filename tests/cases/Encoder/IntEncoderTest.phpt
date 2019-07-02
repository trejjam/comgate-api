<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Tests\Encoder;

use Composer;
use Tester;
use Tester\Assert;
use Trejjam\ComgateApi\Encoder\IntEncoder;

require __DIR__ . '/../../bootstrap.php';

class IntEncoderTest extends Tester\TestCase
{
    /**
     * @var IntEncoder
     */
    private $intEncoder;

    protected function setUp()
    {
        $this->intEncoder = new IntEncoder;
    }

    public function testBoolEncoder()
    {
        Assert::true($this->intEncoder->isApplicable('int'));
        Assert::false($this->intEncoder->isApplicable('string'));

        Assert::same('10', $this->intEncoder->encode(10));
        Assert::same('-10', $this->intEncoder->encode(-10));

        Assert::throws(function () {
            $this->intEncoder->encode('true');
        }, \RuntimeException::class);
    }
}

$test = new IntEncoderTest;
$test->run();
