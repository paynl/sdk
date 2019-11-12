<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Services;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    Service,
    TransformerInterface
};
use PayNL\Sdk\Request\{
    Services\Get,
    RequestInterface,
    AbstractRequest
};

/**
 * Class GetTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Services
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
        $this->request = new Get('1234');
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
    public function testItCanSetAServiceId(): void
    {
        verify(method_exists($this->request, 'setServiceId'))->true();
        verify($this->request->setServiceId('1234'))->isInstanceOf(Get::class);
    }

    /**
     * @depends testItCanSetAServiceId
     *
     * @return void
     */
    public function testItCanGetAServiceId(): void
    {
        verify(method_exists($this->request, 'getServiceId'))->true();

        $this->request->setServiceId('1234');

        verify($this->request->getServiceId())->string();
        verify($this->request->getServiceId())->notEmpty();
        verify($this->request->getServiceId())->equals('1234');
    }

    /**
     * @return void
     */
    public function testItCanGetUri(): void
    {
        $this->request->setServiceId('1234');

        verify($this->request->getUri())->string();
        verify($this->request->getUri())->notEmpty();
        verify($this->request->getUri())->equals('services/1234');
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
        verify($this->request->getTransformer())->isInstanceOf(Service::class);
    }
}
