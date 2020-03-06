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
    use ConfigProviderTestTrait;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->configProvider = new ConfigProvider();
    }
}
