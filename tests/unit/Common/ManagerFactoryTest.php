<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Common;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\AuthAdapter\Manager;
use PayNL\Sdk\Common\ManagerFactory;
use Codeception\Lib\FactoryTestTrait;
use PayNL\Sdk\Exception\ServiceNotCreatedException;
use PayNL\Sdk\Service\AbstractPluginManager;
use UnitTester;

class ManagerFactoryTest extends UnitTest
{
    use FactoryTestTrait;

    /**
     * @var UnitTester
     */
    protected $tester;

    public function _before(): void
    {
        $this->factory = new ManagerFactory();
    }

    public function testItInitiatesAnAbstractPluginManager(): void
    {
        $manager = ($this->factory)($this->tester->getServiceManager(), Manager::class);
        verify($manager)->isInstanceOf(AbstractPluginManager::class);
    }

    public function testInvokeThrowsExceptionMissingConfigKey(): void
    {
        $this->expectException(ServiceNotCreatedException::class);

        ($this->factory)($this->tester->getServiceManager(), '\\PayNL\\Sdk\\NonExistingClassName');
    }

    public function testInvokeThrowsException(): void
    {
        $this->expectException(ServiceNotCreatedException::class);
        ($this->factory)($this->tester->getServiceManager(), 'failingManager');
    }

    public function testInvokeCannotCreateNonAbstractPluginManagers(): void
    {
        $this->expectException(ServiceNotCreatedException::class);

    }
}
