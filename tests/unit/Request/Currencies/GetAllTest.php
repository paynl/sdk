<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Currencies;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\{
    Currencies\GetAll,
    RequestInterface,
    AbstractRequest
};

/**
 * Class GetAllTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Currencies
 */
class GetAllTest extends UnitTest
{
    /**
     * @var GetAll
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->request = new GetAll();
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
        verify($this->request->getUri())->equals('currencies');
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
