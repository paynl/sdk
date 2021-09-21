<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Lib\CollectionTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{
    Member\LinksAwareTrait,
    PaymentMethod,
    PaymentMethods
};

/**
 * Class PaymentMethodsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class PaymentMethodsTest extends UnitTest
{
    use ModelTestTrait;
    use CollectionTestTrait {
        testItCanBeAccessedLikeAnArray as traitTestItCanBeAccessedLikeAnArray;
    }

    /**
     * @var PaymentMethods
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsTotalCollection()
            ->markAsJsonSerializable()
        ;
        $this->model = new PaymentMethods();
    }

    /**
     * @return void
     */
    public function testItHasLinksTrait(): void
    {
        $this->tester->assertObjectUsesTrait($this->model, LinksAwareTrait::class);
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
        $this->tester->assertObjectHasMethod('addPaymentMethod', $this->model);
        $this->tester->assertObjectMethodIsPublic('addPaymentMethod', $this->model);

        verify($this->model->addPaymentMethod($this->getIDeal()))->isInstanceOf(PaymentMethods::class);
    }

    /**
     * @depends testItCanAddPaymentMethod
     *
     * @return void
     */
    public function testItCanSetPaymentMethods(): void
    {
        $this->tester->assertObjectHasMethod('setPaymentMethods', $this->model);
        $this->tester->assertObjectMethodIsPublic('setPaymentMethods', $this->model);

        verify($this->model->setPaymentMethods([]))->isInstanceOf(PaymentMethods::class);
        verify($this->model->setPaymentMethods([ $this->getIDeal() ]))->isInstanceOf(PaymentMethods::class);
    }

    /**
     * @depends testItCanSetPaymentMethods
     *
     * @return void
     */
    public function testItCanGetPaymentMethods(): void
    {
        $this->tester->assertObjectHasMethod('getPaymentMethods', $this->model);
        $this->tester->assertObjectMethodIsPublic('getPaymentMethods', $this->model);

        $this->model->add($this->getIDeal());
        verify($this->model->getPaymentMethods())->array();
        verify($this->model->getPaymentMethods())->count(1);
    }

    /**
     * @depends testItCanSetPaymentMethods
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        $this->traitTestItCanBeAccessedLikeAnArray();

        $paymentProfileIDeal = $this->getIDeal();

        $this->model
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
        verify(isset($this->model[$paymentProfileIDeal->getId()]))->true();
        $nonExistingKey = 'non_existing_key';
        verify($paymentProfileIDeal->getId())->notEquals($nonExistingKey);
        verify($this->model)->hasNotKey($nonExistingKey);

        // offsetGet
        verify($this->model[$paymentProfileIDeal->getId()])->isInstanceOf(PaymentMethod::class);
        verify($this->model[$paymentProfileIDeal->getId()])->equals($paymentProfileIDeal);

        // offsetSet
        $paymentProfilePayPal = $this->getPayPal();
        verify($this->model)->hasNotKey($paymentProfilePayPal->getId());
        $this->model[$paymentProfilePayPal->getId()] = $this->getPayPal();
        verify($this->model)->hasKey($paymentProfilePayPal->getId());
        verify($this->model)->count(2);

        // offsetUnset
        unset($this->model[$paymentProfileIDeal->getId()]);
        verify($this->model)->count(1);
        verify($this->model)->hasNotKey($paymentProfileIDeal->getId());
    }
}
