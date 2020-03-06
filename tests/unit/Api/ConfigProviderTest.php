<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Api;

use Codeception\Lib\ConfigProviderTestTrait;
use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Api\ConfigProvider;

/**
 * Class ConfigProviderTest
 *
 * @package Tests\Unit\PayNL\Sdk\Api
 */
class ConfigProviderTest extends UnitTest
{
    use ConfigProviderTestTrait {
        testItIsCallable as traitTestItIsCallable;
    }

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->configProvider = new ConfigProvider();
    }

    public function testItIsCallable(): void
    {
        $calledOutput = ($this->configProvider)();
        $this->tester->assertArrayMustContainKeys($calledOutput, [
            'service_manager',
            'api'
        ]);

        $this->traitTestItIsCallable();


        $calledOutput = ($this->configProvider)();

        verify($calledOutput)->hasKey('api');
        verify($calledOutput['api'])->array();
        verify($calledOutput['api'])->hasKey('url');
        verify($calledOutput['api'])->hasKey('version');
    }
}
