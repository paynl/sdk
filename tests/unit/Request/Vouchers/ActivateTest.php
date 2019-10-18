<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request\Vouchers;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\Voucher;
use PayNL\Sdk\Request\{
    Vouchers\Activate,
    RequestInterface,
    AbstractRequest
};

/**
 * Class ActivateTest
 *
 * @package Tests\Unit\PayNL\Sdk\Request\Vouchers
 */
class ActivateTest extends UnitTest
{
    /**
     * @var Activate
     */
    protected $request;

    /**
     * @return void
     */
    public function _before(): void
    {
        /** @var Voucher $voucherMock */
        $voucherMock = $this->createMock(Voucher::class);
        $this->request = new Activate('1234', $voucherMock);
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
    public function testItCanSetACardNumber(): void
    {
        verify(method_exists($this->request, 'setCardNumber'))->true();
        verify($this->request->setCardNumber('1234'))->isInstanceOf(Activate::class);
    }

    /**
     * @depends testItCanSetACardNumber
     *
     * @return void
     */
    public function testItCanGetACardNumber(): void
    {
        verify(method_exists($this->request, 'getCardNumber'))->true();

        $this->request->setCardNumber('1234');

        verify($this->request->getCardNumber())->string();
        verify($this->request->getCardNumber())->notEmpty();
        verify($this->request->getCardNumber())->equals('1234');
    }

    /**
     * @return void
     */
    public function testItCanGetUri(): void
    {
        $this->request->setCardNumber('1234');

        verify($this->request->getUri())->string();
        verify($this->request->getUri())->notEmpty();
        verify($this->request->getUri())->equals('vouchers/1234/activate');
    }

    /**
     * @return void
     */
    public function testItCanGetMethod(): void
    {
        verify($this->request->getMethod())->string();
        verify($this->request->getMethod())->notEmpty();
        verify($this->request->getMethod())->equals(RequestInterface::METHOD_PATCH);
    }
}
