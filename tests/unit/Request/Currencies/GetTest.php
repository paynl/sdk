<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Currencies;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\{
    Currencies\Get,
    RequestInterface,
    AbstractRequest
};
use PayNL\Sdk\Transformer\{
    TransformerInterface,
    Currency
};

/**
 * Class GetTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Currencies
 */
class GetTest extends UnitTest
{
    /**
     * @var Get
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->request = new Get('EUR');
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
    public function testItCanSetAnAbbreviation(): void
    {
        verify(method_exists($this->request, 'setAbbreviation'))->true();

        verify($this->request->setAbbreviation('USD'))->isInstanceOf(Get::class);
    }

    /**
     * @depends testItCanSetAnAbbreviation
     *
     * @return void
     */
    public function testItCanGetAnAbbreviation(): void
    {
        verify(method_exists($this->request, 'getAbbreviation'))->true();

        $this->request->setAbbreviation('USD');

        verify($this->request->getAbbreviation())->string();
        verify($this->request->getAbbreviation())->notEmpty();
        verify($this->request->getAbbreviation())->equals('USD');
    }

    /**
     * @return void
     */
    public function testItCanGetUri(): void
    {
        $this->request->setAbbreviation('USD');

        verify($this->request->getUri())->string();
        verify($this->request->getUri())->notEmpty();
        verify($this->request->getUri())->equals('currencies/USD');
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
        verify($this->request->getTransformer())->isInstanceOf(Currency::class);
    }
}
