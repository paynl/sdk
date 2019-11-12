<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\IsPay;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\{
    IsPay\Get,
    RequestInterface,
    AbstractRequest
};
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Transformer\{
    NoContent,
    TransformerInterface
};
use UnitTester;

/**
 * Class GetTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\IsPay
 */
class GetTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var Get
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->request = new Get(Get::TYPE_IP, '0.0.0.0');
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->request)->isInstanceOf(RequestInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->request)->isInstanceOf(AbstractRequest::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionOnNonStringNorIntegerValueInConstructor(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Get('ip', []);
    }

    /**
     * @return void
     */
    public function testItCanSetAType(): void
    {
        verify(method_exists($this->request, 'setType'))->true();
        verify($this->tester->getMethodAccessibility($this->request, 'setType'))->equals('protected');
        verify($this->tester->invokeMethod($this->request, 'setType',  ['test']))->isInstanceOf(Get::class);
    }

    /**
     * @depends testItCanSetAType
     *
     * @return void
     */
    public function testItCanGetAType(): void
    {
        verify(method_exists($this->request, 'getType'))->true();

        $this->tester->invokeMethod($this->request, 'setType', ['test']);

        verify($this->request->getType())->string();
        verify($this->request->getType())->notEmpty();
        verify($this->request->getType())->equals('test');
    }

    /**
     * @return void
     */
    public function testItCanSetAValue(): void
    {
        verify(method_exists($this->request, 'setValue'))->true();
        verify($this->tester->getMethodAccessibility($this->request, 'setValue'))->equals('protected');
        verify($this->tester->invokeMethod($this->request, 'setValue',  ['test']))->isInstanceOf(Get::class);
    }

    /**
     * @depends testItCanSetAValue
     *
     * @return void
     */
    public function testItCanGetAValue(): void
    {
        verify(method_exists($this->request, 'getValue'))->true();

        $this->tester->invokeMethod($this->request, 'setValue', ['test']);

        verify($this->request->getValue())->string();
        verify($this->request->getValue())->notEmpty();
        verify($this->request->getValue())->equals('test');
    }

    /**
     * @return void
     */
    public function testItCanGetUri(): void
    {
        verify($this->request->getUri())->string();
        verify($this->request->getUri())->notEmpty();
        verify($this->request->getUri())->equals('ispay/ip?value=0.0.0.0');
    }

    /**
     * @return void
     */
    public function testItCanGetMethod(): void
    {
        verify($this->request->getMethod())->string();
        verify($this->request->getMethod())->notEmpty();
        verify($this->request->getMethod())->equals(RequestInterface::METHOD_GET);
    }

    /**
     * @return void
     */
    public function testItCanTransform(): void
    {
        verify(method_exists($this->request, 'getTransformer'));
        verify($this->request->getTransformer())->isInstanceOf(TransformerInterface::class);
        verify($this->request->getTransformer())->isInstanceOf(NoContent::class);
    }
}
