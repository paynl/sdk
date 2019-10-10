<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\UnexpectedValueException;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    TransformerInterface
};
use UnitTester, TypeError, stdClass;

/**
 * Class AbstractTransformerTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class AbstractTransformerTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var AbstractTransformer
     */
    protected $anonymousClassFromAbstract;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->anonymousClassFromAbstract = new class() extends AbstractTransformer {
            public function transform($inputToTransform)
            {
                return new stdClass();
            }
        };
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->anonymousClassFromAbstract)->isInstanceOf(TransformerInterface::class);
    }

    /**
     * @return void
     */
    public function testItCanDecodeJson(): void
    {
        $inputString = json_encode([
            'key' => 'value',
        ]);

        $output = $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'getDecodedInput', [ $inputString ]);
        verify($output)->notEquals($inputString);
        verify($output)->array();
        verify($output)->hasKey('key');
        verify($output)->contains('value');
    }

    /**
     * @return void
     */
    public function testItDoesNotAcceptAnInvalidJson(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'getDecodedInput', [ '{"id":1,"test":"blaat"' ]);
    }

    /**
     * @return void
     */
    public function testItDoesNotAcceptAnInputOtherThanString(): void
    {
        $this->expectException(TypeError::class);
        $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'getDecodedInput', [ [] ]);
    }
}
