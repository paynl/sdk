<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Pin;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\{
    Pin\GetTerminals,
    RequestInterface,
    AbstractRequest
};

/**
 * Class GetTerminalsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Pin
 */
class GetTerminalsTest extends UnitTest
{
    /**
     * @var GetTerminals
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->request = new GetTerminals();
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
    public function testItCanGetUri(): void
    {
        verify($this->request->getUri())->string();
        verify($this->request->getUri())->notEmpty();
        verify($this->request->getUri())->equals('pin/terminals');
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
}
