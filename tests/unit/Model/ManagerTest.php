<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Test\Unit as UnitTest,
    Lib\ManagerTestTrait
};
use PayNL\Sdk\{
    Model\ModelInterface,
    Model\Manager,
    Service\AbstractPluginManager
};

/**
 * Class ManagerTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
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
    }

    /**
     * @return void
     */
    public function testItHasADefinedInstanceOfAttribute(): void
    {
        /** @var string $instanceOf */
        $instanceOf = $this->tester->invokeMethod($this->manager, 'getInstanceOf');
        verify($instanceOf)->string();
        verify($instanceOf)->notEmpty();
        verify($instanceOf)->equals(ModelInterface::class);
    }
}
