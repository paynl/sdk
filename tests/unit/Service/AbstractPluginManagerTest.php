<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Service;

use Codeception\{
    Test\Unit as UnitTest,
    Lib\ManagerTestTrait,
    TestAsset\Dummy,
    TestAsset\DummyInterface,
    TestAsset\DummyService,
    TestAsset\SimpleModel
};
use PayNL\Sdk\{
    Exception\InvalidServiceException,
    Exception\ServiceNotFoundException,
    Service\AbstractPluginManager,
    Service\Manager
};
use Exception,
    stdClass
;

class AbstractPluginManagerTest extends UnitTest
{
    use ManagerTestTrait {
        testItCanConfigure as traitTestItCanConfigure;
    }

    /**
     * @var AbstractPluginManager $manager
     */
    protected $manager;

    /**
     * @return void
     */
    public function _before(): void
    {
        $config = [
            'factories' => [
                'foo' => static function () {
                    return new DummyService();
                },
            ],
            'services' => [
                'foo' => (new DummyService()),
            ],
        ];

        $this->manager = new class(null, $config) extends AbstractPluginManager {
            protected $instanceOf = DummyInterface::class;
        };
    }

    /**
     * @return void
     */
    public function testItCanConstruct(): void
    {
        $this->tester->assertClassIsAbstract(AbstractPluginManager::class);
        verify($this->manager)->isInstanceOf(AbstractPluginManager::class);
        verify($this->manager)->isInstanceOf(Manager::class);
    }

    /**
     * @return void
     */
    public function testItCanGetInstanceOf(): void
    {
        $this->tester->assertClassHasMethod('getInstanceOf', AbstractPluginManager::class);
        $this->tester->assertClassMethodIsProtected('getInstanceOf', AbstractPluginManager::class);

        $instanceOf = $this->tester->invokeMethod($this->manager, 'getInstanceOf');
        verify($instanceOf)->string();
        verify($instanceOf)->notEmpty();
        verify($instanceOf)->equals(DummyInterface::class);
    }

    /**
     * @depends testItCanGetInstanceOf
     *
     * @return void
     */
    public function testItCanValidate(): void
    {
        try {
            $manager = new class() extends AbstractPluginManager {};
            $manager->validate(new stdClass());
        } catch (Exception $e) {
            $this->fail();
        }
        verify(true)->true();

        try {
            $this->manager->validate(new Dummy());
        } catch (Exception $e) {
            $this->fail();
        }
        verify(true)->true();
    }

    /**
     * @depends testItCanValidate
     *
     * @return void
     */
    public function testValidateThrowsAnExceptionOnWrongInstance(): void
    {
        $this->expectException(InvalidServiceException::class);
        $this->manager->validate(new SimpleModel());
    }

    /**
     * @depends testItCanValidate
     *
     * @return void
     */
    public function testItCanConfigure(): void
    {
        $this->traitTestItCanConfigure();

        try {
            $configuredManager = $this->manager->configure([
                'aliases' => [
                    'dummy' => 'Dummy',
                ],
                'invokables' => [
                    'Dummy' => Dummy::class,
                ],
                'services' => [
                    'thud' => (new Dummy()),
                ],
            ]);
            verify($configuredManager)->same($this->manager);
        } catch (Exception $e) {
            $this->fail();
        }
        verify(true)->true();
    }

    /**
     * @depends testItCanValidate
     *
     * @return void
     */
    public function testItCanBuildANamedService(): void
    {
        $foo = $this->manager->build('foo');
        verify($foo)->object();
        verify($foo)->isInstanceOf(DummyService::class);

        $bar = $this->manager->build('foo');
        verify($bar)->object();
        verify($bar)->isInstanceOf(DummyService::class);
        verify($bar)->notSame($foo);
    }

    /**
     * @depends testItCanValidate
     * @depends testItCanBuildANamedService
     *
     * @return void
     */
    public function testItCanGetANamedService(): void
    {
        $foo = $this->manager->get('foo');
        verify($foo)->object();
        verify($foo)->isInstanceOf(DummyService::class);

        $bar = $this->manager->get('foo');
        verify($bar)->same($foo);

        $baz = $this->manager->get('foo', ['name' => 'value']);
        verify($baz)->notSame($bar);
    }

    /**
     * @depends testItCanGetANamedService
     *
     * @return void
     */
    public function testGetANamedServiceThrowsAnExceptionWhenNameDoesNotExist(): void
    {
        $this->expectException(ServiceNotFoundException::class);
        $this->manager->get('bar');
    }
}
