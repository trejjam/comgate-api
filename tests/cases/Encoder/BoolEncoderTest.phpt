<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Tests\Encoder;

use Composer;
use Tester;
use Tester\Assert;
use Trejjam\ComgateApi\Encoder\BoolEncoder;

require __DIR__ . '/../../bootstrap.php';

class BoolEncoderTest extends Tester\TestCase
{
    /**
     * @var BoolEncoder
     */
    private $boolEncoder;

    protected function setUp()
    {
        $this->boolEncoder = new BoolEncoder;
    }

    public function testBoolEncoder()
    {
        Assert::true($this->boolEncoder->isApplicable('bool'));
        Assert::false($this->boolEncoder->isApplicable('string'));

        Assert::same('true', $this->boolEncoder->encode(true));
        Assert::same('false', $this->boolEncoder->encode(false));

        Assert::throws(function () {
            $this->boolEncoder->encode('true');
        }, \RuntimeException::class);
    }
}

$test = new BoolEncoderTest;
$test->run();
