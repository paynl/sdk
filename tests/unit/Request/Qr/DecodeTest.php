<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Qr;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    Qr,
    TransformerInterface
};
use PayNL\Sdk\Request\{
    Qr\Decode,
    RequestInterface,
    AbstractRequest
};

/**
 * Class DecodeTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Qr
 */
class DecodeTest extends UnitTest
{
    /**
     * @var Decode
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->request = new Decode('username', 'secret');
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
        verify($this->request->getUri())->equals('qr/decode');
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

    /**
     * @return void
     */
    public function testItCanTransform(): void
    {
        verify(method_exists($this->request, 'getTransformer'));
        verify($this->request->getTransformer())->isInstanceOf(TransformerInterface::class);
        verify($this->request->getTransformer())->isInstanceOf(Qr::class);
    }
}
