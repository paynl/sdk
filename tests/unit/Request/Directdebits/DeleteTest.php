<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Directdebits;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\{
    Directdebits\Delete,
    RequestInterface,
    AbstractRequest
};

/**
 * Class DeleteTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Directdebits
 */
class DeleteTest extends UnitTest
{
    /**
     * @var Delete
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->request = new Delete('1234');
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
    public function testItCanSetAnIncassoOrderId(): void
    {
        verify(method_exists($this->request, 'setIncassoOrderId'))->true();
        verify($this->request->setIncassoOrderId('1234'))->isInstanceOf(Delete::class);
    }

    /**
     * @depends testItCanSetAnIncassoOrderId
     *
     * @return void
     */
    public function testItCanGetAnIncassoOrderId(): void
    {
        verify(method_exists($this->request, 'getIncassoOrderId'))->true();

        $this->request->setIncassoOrderId('1234');

        verify($this->request->getIncassoOrderId())->string();
        verify($this->request->getIncassoOrderId())->notEmpty();
        verify($this->request->getIncassoOrderId())->equals('1234');
    }

    /**
     * @return void
     */
    public function testItCanGetUri(): void
    {
        verify($this->request->getUri())->string();
        verify($this->request->getUri())->notEmpty();
        verify($this->request->getUri())->equals('directdebits/1234');
    }

    /**
     * @return void
     */
    public function testItCanGetMethod(): void
    {
        verify($this->request->getMethod())->string();
        verify($this->request->getMethod())->notEmpty();
        verify($this->request->getMethod())->equals(RequestInterface::METHOD_DELETE);
    }
}
