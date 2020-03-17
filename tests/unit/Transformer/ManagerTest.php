<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Lib\ManagerTestTrait;
use CodeCeption\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\Manager;
use PayNL\Sdk\Service\AbstractPluginManager;
use PayNL\Sdk\Transformer\TransformerInterface;

/**
 * Class ManagerTest
 *
 * @package Tests\Unit\PayNL\Sdk\Validator
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
        verify($instanceOf)->equals(TransformerInterface::class);
    }
}
