<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Filter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Filter\{
    AbstractScalar,
    PaymentMethodId
};

/**
 * Class PaymentMethodIdTest
 *
 * @package Tests\Unit\PayNL\Sdk\Filter
 */
class PaymentMethodIdTest extends UnitTest
{
    /**
     * @var PaymentMethodId
     */
    protected $filter;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->filter = new PaymentMethodId(123);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->filter)->isInstanceOf(AbstractScalar::class);
    }

    /**
     * @return void
     */
    public function testItHasAName(): void
    {
        verify($this->filter->getName())->string();
        verify($this->filter->getName())->notEmpty();
        verify($this->filter->getName())->equals('paymentMethodId');
    }

    /**
     * @return void
     */
    public function testItContainsAValue(): void
    {
        verify($this->filter->getValue())->string();
        verify($this->filter->getValue())->notEmpty();
        verify($this->filter->getValue())->equals('123');
    }
}
