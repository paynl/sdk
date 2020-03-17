<?php

declare(strict_types=1);

namespace Codeception\Lib;

use Psr\Container\ContainerInterface;
use PayNL\Sdk\Service\Manager as ServiceManager;
use UnitTester;

/**
 * Trait ManagerTestTrait
 *
 * @package Codeception\Lib
 */
trait ManagerTestTrait
{
    /**
     * @var ServiceManager
     */
    protected $manager;

    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testItIsAManager(): void
    {
        verify($this->manager)->isInstanceOf(ContainerInterface::class);
        verify($this->manager)->isInstanceOf(ServiceManager::class);
    }

    /**
     * @depends testItIsAManager
     * @return void
     */
    public function testItCanConfigure(): void
    {
        $this->tester->assertObjectHasMethod('configure', $this->manager);
        verify($this->manager->configure([]))
            ->isInstanceOf(get_class($this->manager));
    }
}
