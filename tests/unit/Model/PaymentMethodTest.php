<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\PaymentMethod;
use PayNL\Sdk\Model\ModelInterface;

/**
 * Class PaymentMethodTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class PaymentMethodTest extends UnitTest
{
    /**
     * @var PaymentMethod
     */
    protected $paymentMethod;

    public function _before(): void
    {
        $this->paymentMethod = new PaymentMethod();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->paymentMethod)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->paymentMethod)->isNotInstanceOf(\JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        expect($this->paymentMethod->setId(10))->isInstanceOf(PaymentMethod::class);
    }

    /**
     * @depends testItCanSetAnId
     *
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $this->paymentMethod->setId(10);

        verify($this->paymentMethod->getId())->int();
        verify($this->paymentMethod->getId())->notEmpty();
        verify($this->paymentMethod->getId())->equals(10);
    }

    /**
     * @return void
     */
    public function testItCanSetAName(): void
    {
        expect($this->paymentMethod->setName('iDeal'))->isInstanceOf(PaymentMethod::class);
    }

    /**
     * @depends testItCanSetAName
     *
     * @return void
     */
    public function testItCanGetAName(): void
    {
        $this->paymentMethod->setName('iDeal');

        verify($this->paymentMethod->getName())->string();
        verify($this->paymentMethod->getName())->notEmpty();
        verify($this->paymentMethod->getName())->equals('iDeal');
    }

    /**
     * @return void
     */
    public function testItCanSetSettings(): void
    {
        expect($this->paymentMethod->setSettings([
            'entryKey' => 'entryValue',
        ]))->isInstanceOf(PaymentMethod::class);
    }

    /**
     * @depends testItCanSetSettings
     *
     * @return void
     */
    public function testItCanGetSettings(): void
    {
        $this->paymentMethod->setSettings([
            'entryValue',
        ]);

        verify($this->paymentMethod->getSettings())->array();
        verify($this->paymentMethod->getSettings())->count(1);
        verify($this->paymentMethod->getSettings())->contains('entryValue');
    }
}
