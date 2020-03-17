<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use Codeception\TestAsset\DummyTransformer;
use PayNL\Sdk\Exception\UnexpectedValueException;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    TransformerInterface
};
use UnitTester, TypeError;

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
        $this->anonymousClassFromAbstract = new DummyTransformer($this->tester->getServiceManager());
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
    public function testItCanFilterNotNull(): void
    {
        $inputArray = [
            'key'                  => 'value',
            'key_with_empty_value' => null,
            'recursive_key'        => [
                'i_key'       => 'value',
                'i_key_empty' => '',
            ]
        ];

        $output = $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'filterNotNull', [ $inputArray ]);

        verify($output)->array();
        verify($output)->notEmpty();
        verify($output)->hasKey('key');
        verify($output['key'])->string();
        verify($output['key'])->equals('value');
        verify($output)->hasntKey('key_with_empty_value');
        verify($output)->hasKey('recursive_key');
        verify($output['recursive_key'])->array();
        verify($output['recursive_key'])->hasKey('i_key');
        verify($output['recursive_key']['i_key'])->string();
        verify($output['recursive_key']['i_key'])->equals('value');
        verify($output['recursive_key'])->hasntKey('i_key_empty');
    }

    /**
     * @return void
     */
    public function testItCanDecodeJson(): void
    {
        $inputString = json_encode([
            'key'                  => 'value',
            'key_with_empty_value' => null,
            'recursive_key'        => [
                'i_key'       => 'value',
                'i_key_empty' => '',
            ]
        ]);

        $output = $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'getDecodedInput', [ $inputString ]);
        verify($output)->notEquals($inputString);
        verify($output)->array();
        verify($output)->hasKey('key');
        verify($output['key'])->string();
        verify($output['key'])->equals('value');
        verify($output)->hasntKey('key_with_empty_value');
        verify($output)->hasKey('recursive_key');
        verify($output['recursive_key'])->array();
        verify($output['recursive_key'])->hasKey('i_key');
        verify($output['recursive_key']['i_key'])->string();
        verify($output['recursive_key']['i_key'])->equals('value');
        verify($output['recursive_key'])->hasntKey('i_key_empty');
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
    public function testItDoesThrowAnExceptionWhenDecodedJsonIsNotAnArray(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'getDecodedInput', [ 'test' ]);
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
