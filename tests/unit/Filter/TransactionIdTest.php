<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Filter;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Filter\{
    AbstractScalar,
    TransactionId
};

/**
 * Class TransactionIdTest
 *
 * @package Tests\Unit\PayNL\Sdk\Filter
 */
class TransactionIdTest extends UnitTest
{
    /**
     * @var TransactionId
     */
    protected $filter;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->filter = new TransactionId('IDtje');
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
        verify($this->filter->getName())->equals('transactionId');
    }

    /**
     * @return void
     */
    public function testItContainsAValue(): void
    {
        verify($this->filter->getValue())->string();
        verify($this->filter->getValue())->notEmpty();
        verify($this->filter->getValue())->equals('IDtje');
    }
}
