<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Common\AbstractTotalCollection;
use PayNL\Sdk\Common\JsonSerializeTrait;
use PayNL\Sdk\Model\{
    LinksTrait,
    ModelInterface,
    Links,
    PaymentMethod,
    PaymentMethods
};
use JsonSerializable, Countable, ArrayAccess, IteratorAggregate;
use UnitTester;

/**
 * Class PaymentMethodsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class PaymentMethodsTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @var PaymentMethods
     */
    protected $paymentMethods;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->paymentMethods = new PaymentMethods();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->paymentMethods)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testItIsATotalCollection(): void
    {
        verify($this->paymentMethods)->isInstanceOf(AbstractTotalCollection::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->paymentMethods)->isInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItHasLinksTrait(): void
    {
        verify(in_array(LinksTrait::class, class_uses($this->paymentMethods), true))->true();
    }

    /**
     * @return void
     */
    public function testItHasJsonSerializableTrait(): void
    {
        verify(in_array(JsonSerializeTrait::class, class_uses($this->paymentMethods), true))->true();
    }

    /**
     * @return void
     */
    public function testItCanSetLinks(): void
    {
        verify(method_exists($this->paymentMethods, 'setLinks'))->true();
        verify($this->paymentMethods->setLinks(new Links()))->isInstanceOf(PaymentMethods::class);
    }

    /**
     * @return PaymentMethod
     */
    private function getPaymentMethodMock(): PaymentMethod
    {
        return $this->tester->grabService('modelManager')->get('PaymentMethod');
    }

    /**
     * @return PaymentMethod
     */
    private function getIDeal(): PaymentMethod
    {
        return ($this->getPaymentMethodMock())
            ->setId(10)
            ->setSubId(1)
            ->setName('iDeal')
            ->setImage('https://admin.pay.nl/images/payment_profiles/10.gif')
            ->setCountryCodes(['NL']);
    }

    /**
     * @return PaymentMethod
     */
    private function getABNAmro(): PaymentMethod
    {
        return ($this->getPaymentMethodMock())
            ->setId(1)
            ->setName('ABN Amro')
            ->setImage('https://admin.pay.nl/images/payment_banks/1.png');
    }

    /**
     * @return PaymentMethod
     */
    private function getASNBank(): PaymentMethod
    {
        return ($this->getPaymentMethodMock())
            ->setId(8)
            ->setName('ASN Bank')
            ->setImage('https://admin.pay.nl/images/payment_banks/8.png');
    }

    /**
     * @return PaymentMethod
     */
    private function getPayPal(): PaymentMethod
    {
        return ($this->getPaymentMethodMock())
            ->setId(138)
            ->setName('PayPal');
    }

    /**
     * @return void
     */
    public function testItCanAddPaymentMethod(): void
    {
        verify(method_exists($this->paymentMethods, 'addPaymentMethod'))->true();
        verify($this->paymentMethods->addPaymentMethod($this->getIDeal()))->isInstanceOf(PaymentMethods::class);
    }

    /**
     * @depends testItCanAddPaymentMethod
     *
     * @return void
     */
    public function testItCanSetPaymentMethods(): void
    {
        verify(method_exists($this->paymentMethods, 'setPaymentMethods'))->true();
        verify($this->paymentMethods->setPaymentMethods([]))->isInstanceOf(PaymentMethods::class);
        verify($this->paymentMethods->setPaymentMethods([ $this->getIDeal() ]))->isInstanceOf(PaymentMethods::class);
    }

    /**
     * @depends testItCanSetPaymentMethods
     *
     * @return void
     */
    public function testItCanGetPaymentMethods(): void
    {
        verify(method_exists($this->paymentMethods, 'getPaymentMethods'))->true();
        $this->paymentMethods->add($this->getIDeal());
        verify($this->paymentMethods->getPaymentMethods())->array();
        verify($this->paymentMethods->getPaymentMethods())->count(1);
    }

    /**
     * @return void
     */
    public function testItCanSetTotal(): void
    {
        verify(method_exists($this->paymentMethods, 'setTotal'))->true();
        verify($this->paymentMethods->setTotal(1))->isInstanceOf(PaymentMethods::class);
    }

    /**
     * @depends testItCanSetTotal
     *
     * @return void
     */
    public function testItCanGetTotal(): void
    {
        verify(method_exists($this->paymentMethods, 'getTotal'))->true();

        $this->paymentMethods->setTotal(1);

        verify($this->paymentMethods->getTotal())->int();
        verify($this->paymentMethods->getTotal())->notEmpty();
        verify($this->paymentMethods->getTotal())->equals(1);
    }


    /**
     * @depends testItCanSetPaymentMethods
     *
     * @return void
     */
    public function testItIsCountable(): void
    {
        verify($this->paymentMethods)->isInstanceOf(Countable::class);
        $this->paymentMethods
            ->setPaymentMethods([
                $this->getIDeal()
                    ->setSubMethods(
                        (new PaymentMethods())->setPaymentMethods([
                            $this->getABNAmro(),
                            $this->getASNBank()
                        ])
                    )
            ]);

        verify(count($this->paymentMethods))->equals(1);
    }

    /**
     * @depends testItCanSetPaymentMethods
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        verify($this->paymentMethods)->isInstanceOf(ArrayAccess::class);
        $paymentProfileIDeal = $this->getIDeal();

        $this->paymentMethods
            ->setPaymentMethods([
                $paymentProfileIDeal
                    ->setSubMethods(
                        (new PaymentMethods())->setPaymentMethods([
                            $this->getABNAmro(),
                            $this->getASNBank()
                        ])
                    )
            ]);

        // offsetExists
        verify(isset($this->paymentMethods[$paymentProfileIDeal->getId()]))->true();
        $nonExistingKey = 'non_existing_key';
        verify($paymentProfileIDeal->getId())->notEquals($nonExistingKey);
        verify($this->paymentMethods)->hasntKey($nonExistingKey);

        // offsetGet
        verify($this->paymentMethods[$paymentProfileIDeal->getId()])->isInstanceOf(PaymentMethod::class);
        verify($this->paymentMethods[$paymentProfileIDeal->getId()])->equals($paymentProfileIDeal);

        // offsetSet
        $paymentProfilePayPal = $this->getPayPal();
        verify($this->paymentMethods)->hasntKey($paymentProfilePayPal->getId());
        $this->paymentMethods[$paymentProfilePayPal->getId()] = $this->getPayPal();
        verify($this->paymentMethods)->hasKey($paymentProfilePayPal->getId());
        verify($this->paymentMethods)->count(2);

        // offsetUnset
        unset($this->paymentMethods[$paymentProfileIDeal->getId()]);
        verify($this->paymentMethods)->count(1);
        verify($this->paymentMethods)->hasntKey($paymentProfileIDeal->getId());
    }

    /**
     * @depends testItCanSetPaymentMethods
     *
     * @return void
     */
    public function testItCanBeIterated(): void
    {
        verify($this->paymentMethods)->isInstanceOf(IteratorAggregate::class);

        $this->paymentMethods->setPaymentMethods([ $this->getPayPal() ]);

        verify(is_iterable($this->paymentMethods))->true();
    }
}
