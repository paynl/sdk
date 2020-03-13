<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request;

use PayNL\Sdk\Request\Factory;
use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\Request;
use PayNL\Sdk\Request\RequestInterface;
use UnitTester;

/**
 * Class FactoryTest
 * @package Tests\Unit\PayNL\Sdk\Request
 */
class FactoryTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

    /** @var Factory */
    private $factory;

    protected function _before()
    {
        $this->factory = new Factory();
    }

    /**
     * @return void
     */
    public function testItIsInvokable(): void
    {
        verify($this->factory)->callable();
    }

    public function testItCanCreateRequest(): void
    {
        $filter = ($this->factory)($this->tester->getServiceManager(), Request::class, [
            'uri' => 'www.pay.nl',
            'method' => RequestInterface::METHOD_GET,
        ]);
        verify($filter)->isInstanceOf(Request::class);
    }

}