<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Hydrator\Mandate as MandateHydrator;
use PayNL\Sdk\Model\{
    Amount,
    BankAccount,
    Customer,
    Interval,
    Mandate,
    Statistics
};
use PayNL\Sdk\Exception\InvalidArgumentException;
use Zend\Hydrator\HydratorInterface;
use Exception, DateTime;

/**
 * Class MandateTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class MandateTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new MandateHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldAcceptAMandateModel(): void
    {
        $hydrator = new MandateHydrator();
        expect($hydrator->hydrate([], new Mandate()))->isInstanceOf(Mandate::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new MandateHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new MandateHydrator();
        $directdebit = $hydrator->hydrate([
            'id'          => 'IO-8284-8371-9550',
            'type'        => 'single',
            'serviceId'   => 'SL-5796-8370',
            'description' => 'Test directdebit',
            'state'       => 'single',
            'processDate' => DateTime::createFromFormat('Y-m-d H:i:s', '2019-10-07 08:39:42'),
            'exchangeUrl' => 'https://www.pay.nl/exchange-url',
            'customer' => [
                'ip' => '66.249.64.0',
                'email' => 'somebody@somedomain.com',
                'bankAccount' => [
                    'owner' => 'PAY.',
                    'bic' => 'RABONL2U',
                    'iban' => 'NL32RABO1670475085',
                ],
            ],
            'amount' => [
                'amount' => 100,
                'currency' => 'EUR',
            ],
            'interval' => [
                'period' => 'Month',
                'quantity' => 1,
                'value' => 1,
            ],
            'statistics' => [
                'promoterId' => 0,
                'info' => 'test',
                'tool' => 'some-tool',
                'extra1' => '',
                'extra2' => '',
                'extra3' => '',
                'transferData' => [
                    'data'
                ],
            ],
            'isLastOrder' => false,
        ], new Mandate());

        expect($directdebit->getId())->string();
        expect($directdebit->getId())->equals('IO-8284-8371-9550');
        expect($directdebit->getType())->string();
        expect($directdebit->getType())->equals('single');
        expect($directdebit->getServiceId())->string();
        expect($directdebit->getServiceId())->equals('SL-5796-8370');
        expect($directdebit->getDescription())->string();
        expect($directdebit->getDescription())->equals('Test directdebit');
        expect($directdebit->getState())->string();
        expect($directdebit->getState())->equals('single');
        expect($directdebit->getProcessDate())->isInstanceOf(DateTime::class);
        expect($directdebit->getExchangeUrl())->string();
        expect($directdebit->getExchangeUrl())->equals('https://www.pay.nl/exchange-url');
        expect($directdebit->getCustomer())->isInstanceOf(Customer::class);
        expect($directdebit->getAmount())->isInstanceOf(Amount::class);
        expect($directdebit->getInterval())->isInstanceOf(Interval::class);
        expect($directdebit->getStatistics())->isInstanceOf(Statistics::class);
        expect($directdebit->isLastOrder())->bool();
        expect($directdebit->isLastOrder())->false();
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new MandateHydrator();
        $directdebit = $hydrator->hydrate([
            'id'          => 'IO-8284-8371-9550',
            'type'        => 'single',
            'serviceId'   => 'SL-5796-8370',
            'description' => 'Test directdebit',
            'state'       => 'single',
            'processDate' => DateTime::createFromFormat('Y-m-d H:i:s', '2019-10-07 08:39:42'),
            'exchangeUrl' => 'https://www.pay.nl/exchange-url',
            'customer' => [
                'ip' => '66.249.64.0',
                'email' => 'somebody@somedomain.com',
                'bankAccount' => [
                    'owner' => 'PAY.',
                    'bic' => 'RABONL2U',
                    'iban' => 'NL32RABO1670475085',
                ],
            ],
            'amount' => [
                'amount' => 100,
                'currency' => 'EUR',
            ],
            'interval' => [
                'period' => 'Month',
                'quantity' => 1,
                'value' => 1,
            ],
            'statistics' => [
                'promoterId' => 0,
                'info' => 'test',
                'tool' => 'some-tool',
                'extra1' => '',
                'extra2' => '',
                'extra3' => '',
                'transferData' => [
                    'data'
                ],
            ],
            'isLastOrder' => false,
        ], new Mandate());

        $data = $hydrator->extract($directdebit);
        $this->assertIsArray($data);
        verify($data)->hasKey('id');
        verify($data)->hasKey('type');
        verify($data)->hasKey('serviceId');
        verify($data)->hasKey('description');
        verify($data)->hasKey('state');
        verify($data)->hasKey('processDate');
        verify($data)->hasKey('exchangeUrl');
        verify($data)->hasKey('customer');
        verify($data)->hasKey('amount');
        verify($data)->hasKey('interval');
        verify($data)->hasKey('statistics');
        verify($data)->hasKey('isLastOrder');

        expect($data['id'])->string();
        expect($data['id'])->equals('IO-8284-8371-9550');
        expect($data['type'])->string();
        expect($data['type'])->equals('single');
        expect($data['serviceId'])->string();
        expect($data['serviceId'])->equals('SL-5796-8370');
        expect($data['description'])->string();
        expect($data['description'])->equals('Test directdebit');
        expect($data['state'])->string();
        expect($data['state'])->equals('single');
        expect($data['processDate'])->isInstanceOf(DateTime::class);
        expect($data['exchangeUrl'])->string();
        expect($data['exchangeUrl'])->equals('https://www.pay.nl/exchange-url');
        expect($data['customer'])->isInstanceOf(Customer::class);
        expect($data['amount'])->isInstanceOf(Amount::class);
        expect($data['interval'])->isInstanceOf(Interval::class);
        expect($data['statistics'])->isInstanceOf(Statistics::class);
        expect($data['isLastOrder'])->bool();
        expect($data['isLastOrder'])->false();
    }
}
