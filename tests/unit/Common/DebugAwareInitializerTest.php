<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Common;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Common\DebugAwareInitializer;
use PayNL\Sdk\Common\DebugAwareInterface;
use PayNL\Sdk\Common\InitializerInterface;
use Psr\Container\ContainerInterface;
use UnitTester;

class DebugAwareInitializerTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var InitializerInterface
     */
    protected $initializer;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->initializer = new DebugAwareInitializer();

        $this->container = new class() implements ContainerInterface
        {
            protected $data = [
                'config' => [
                    'debug' => true,
                ],
            ];

            public function get($id)
            {
                return $this->data[$id];
            }

            public function has($id): bool
            {
                return array_key_exists($id, $this->data);
            }
        };
    }

    /**
     * @return void
     */
    public function testItIsAnInitializer(): void
    {
        verify($this->initializer)->isInstanceOf(InitializerInterface::class);
    }

    /**
     * @return void
     */
    public function testItIsCallable(): void
    {
        $this->tester->assertClassHasMethod('__invoke', DebugAwareInitializer::class);
        verify($this->initializer)->callable();
    }

    /**
     * @return void
     */
    public function testItCanSetDebugModeOnDebugAwareInstance(): void
    {
        $debugAwareInstance = new class() implements DebugAwareInterface {
            protected $debug = false;

            public function setDebug(bool $debug)
            {
                $this->debug = $debug;
                return $this;
            }

            public function isDebug(): bool
            {
                return true === $this->debug;
            }
        };

        ($this->initializer)($this->container, $debugAwareInstance);

        verify($debugAwareInstance->isDebug())->true();
    }

    /**
     * @return void
     */
    public function testItDoesNothingForNonDebugAwareInstance(): void
    {
        $nonDebugAwareInstance = new class() {};
        $copy = $nonDebugAwareInstance;

        ($this->initializer)($this->container, $nonDebugAwareInstance);

        verify($nonDebugAwareInstance)->same($copy);
    }
}
