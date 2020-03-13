<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request;

use Codeception\Lib\ManagerTestTrait;
use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\ConfigProvider;
use PayNL\Sdk\Request\Request;
use PayNL\Sdk\Service\AbstractPluginManager;
use PayNL\Sdk\Request\Manager;

/**
 * Class ManagerTest
 * @package Tests\Unit\PayNL\Sdk\Request
 */
class ManagerTest extends UnitTest
{
    use ManagerTestTrait {
        testItIsAManager as traitTestItIsAManager;
    }

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->manager = new Manager();
    }

    /**
     * @inheritDoc
     */
    public function testItIsAManager(): void
    {
        $this->traitTestItIsAManager();
        verify($this->manager)->isInstanceOf(AbstractPluginManager::class);
        $this->assertObjectHasAttribute('instanceOf', $this->manager);
        verify($this->manager)->isInstanceOf(Manager::class);
    }

    /**
     * @depends testItIsAManager
     * @return void
     */
    public function testItCanConfigure(): void
    {
        $config = (new ConfigProvider())();
        verify($this->manager->configure($config))->isInstanceOf(Manager::class);
    }

    /**
     * @depends testItIsAManager
     * @return void
     */
    public function testItCanInjectValidatorManager(): void
    {
        $container = $this->tester->getServiceManager();
        $request = new Request('www.pay.nl');
        verify($this->manager->injectValidatorManager($container, $request))->null();
    }
}