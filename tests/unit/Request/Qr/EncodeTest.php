<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Qr;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\Qr;
use PayNL\Sdk\Request\{
    Qr\Encode,
    RequestInterface,
    AbstractRequest
};

/**
 * Class EncodeTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Qr
 */
class EncodeTest extends UnitTest
{
    /**
     * @var Encode
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        /** @var Qr $qrModelMock */
        $qrModelMock = $this->createMock(Qr::class);
        $this->request = new Encode($qrModelMock);
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
        verify($this->request->getUri())->equals('qr/encode');
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
