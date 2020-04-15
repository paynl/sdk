<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Config;

use Codeception\Test\Unit as UnitTest;
use Codeception\Lib\FactoryTestTrait;
use PayNL\Sdk\Config\Config;
use PayNL\Sdk\Config\Factory;
use UnitTester;

class FactoryTest extends UnitTest
{
    use FactoryTestTrait;

    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->factory = new Factory();
    }

    /**
     * @return void
     */
    public function testItReturnAConfigInstance(): void
    {
        $output = ($this->factory)(
            $this->tester->getServiceManager(),
            ''
        );

        verify($output)->object();
        verify($output)->isInstanceOf(Config::class);
    }
}
