<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Services;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\ServicePaymentLink;
use PayNL\Sdk\Request\{
    Services\CreatePaymentLink,
    RequestInterface,
    AbstractRequest
};

/**
 * Class CreatePaymentLinkTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Services
 */
class CreatePaymentLinkTest extends UnitTest
{
    /**
     * @var CreatePaymentLink
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        /** @var ServicePaymentLink $servicePaymentLinkMock */
        $servicePaymentLinkMock = $this->createMock(ServicePaymentLink::class);
        $this->request = new CreatePaymentLink('1234', $servicePaymentLinkMock);
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
        verify($this->request->setServiceId('1234'))->isInstanceOf(CreatePaymentLink::class);
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
        verify($this->request->getUri())->equals('services/1234/paymentlink');
    }

    /**
     * @return void
     */
    public function testItCanGetMethod(): void
    {
        verify($this->request->getMethod())->string();
        verify($this->request->getMethod())->notEmpty();
        verify($this->request->getMethod())->equals(RequestInterface::METHOD_POST);
    }
}
