<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Service;

use Codeception\Test\Unit as UnitTest;
use Codeception\Lib\ManagerTestTrait;
use Codeception\TestAsset\Dummy;
use Codeception\TestAsset\DummyFactory;
use Codeception\TestAsset\DummyInitializer;
use Codeception\TestAsset\DummyService;
use Codeception\TestAsset\FailingModel;
use Codeception\TestAsset\FailingPluginManager;
use Codeception\TestAsset\InvokableObject;
use Codeception\TestAsset\SampleFactory;
use Codeception\TestAsset\SecondDummyInitializer;
use Codeception\TestAsset\SimpleCollection;
use Codeception\TestAsset\SimpleModel;
use PayNL\Sdk\Common\InvokableFactory;
use PayNL\Sdk\Exception\ContainerModificationsNotAllowedException;
use PayNL\Sdk\Exception\CyclicAliasException;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Exception\ServiceNotCreatedException;
use PayNL\Sdk\Exception\ServiceNotFoundException;
use PayNL\Sdk\Service\Manager;
use Exception;

class ManagerTest extends UnitTest
{
    use ManagerTestTrait {
        testItCanConfigure as traitTestItCanConfigure;
    }

    public function _before(): void
    {
        $dummyService = new DummyService();

        $cnf = [
            'aliases' => [
                'foo_bar' => InvokableObject::class,
                'corge' => 'foo_bar',
//                'thud' => 'waldo',
            ],
            'factories' => [
                InvokableObject::class => SampleFactory::class,
            ],
            'initializers' => [
                DummyInitializer::class,
            ],
            'invokables' => [
                'Dummy' => Dummy::class,
            ],
            'services' => [
                'foo' => $dummyService,
            ],
        ];

        $this->manager = new Manager($cnf);
    }

    /**
     * @return void
     */
    public function testItCanConstruct(): void
    {
        verify($this->manager)->isInstanceOf(Manager::class);
        verify(new Manager([]))->isInstanceOf(Manager::class);
    }

    /**
     * @return void
     */
    public function testItCanValidateOverrideSet(): void
    {
        $this->tester->assertClassHasMethod('validateOverrideSet', Manager::class);
        $this->tester->assertClassMethodIsProtected('validateOverrideSet', Manager::class);
        try {
            $this->tester->invokeMethod(
                $this->manager,
                'validateOverrideSet',
                [
                    [
                        'bar'
                    ],
                    'service'
                ]
            );
        } catch (Exception $e) {
            $this->fail();
        }

        verify(true)->true();
    }

    /**
     * @return void
     */
    public function testValidateOverrideSetThrowsAnExceptionForExistingService(): void
    {
        $this->expectException(ContainerModificationsNotAllowedException::class);
        $this->tester->invokeMethod(
            $this->manager,
            'validateOverrideSet',
            [
                [
                    'foo'
                ],
                'service'
            ]
        );
    }

    /**
     * @return void
     */
    public function testItCanCheckAllowOverride(): void
    {
        verify($this->manager->hasAllowOverride())->bool();
        verify($this->manager->hasAllowOverride())->false();
    }

    /**
     * @depends testItCanCheckAllowOverride
     *
     * @return void
     */
    public function testItCanSetAllowOverride(): void
    {
        verify($this->manager->setAllowOverride(true))->same($this->manager);
        verify($this->manager->hasAllowOverride())->true();
    }

    /**
     * @depends testItCanValidateOverrideSet
     * @depends testItCanSetAllowOverride
     *
     * @return void
     */
    public function testItCanValidateOverrides(): void
    {
        $this->tester->assertClassHasMethod('validateOverrides', Manager::class);
        $this->tester->assertClassMethodIsProtected('validateOverrides', Manager::class);

        try {
            $this->tester->invokeMethod($this->manager, 'validateOverrides', [[]]);
        } catch (Exception $e) {
            $this->fail();
        }

        verify(true)->true();

        $this->manager->setAllowOverride(true);

        try {
            $this->tester->invokeMethod($this->manager, 'validateOverrides', [[
                'services'   => [
                    'thud' => (new DummyService()),
                ],
                'aliases'    => [
                    'corge'  => Dummy::class,
                    'grault' => 'garply',
                ],
                'invokables' => [
                    'garply' => InvokableObject::class,
                ],
                'factories'  => [
                    Dummy::class => DummyFactory::class,
                ]
            ]]);
        } catch (Exception $e) {
            $this->fail();
        }

        verify(true)->true();

        $this->manager->setAllowOverride(false);
    }

    /**
     * @return void
     */
    public function testItCanCreateAliasesForInvokables(): void
    {
        $this->tester->assertClassHasMethod('createAliasesForInvokables', Manager::class);
        $this->tester->assertClassMethodIsPrivate('createAliasesForInvokables', Manager::class);

        $aliases = $this->tester->invokeMethod($this->manager, 'createAliasesForInvokables', [[
            Dummy::class => Dummy::class,
            'dummy'      => Dummy::class,
        ]]);
        verify($aliases)->array();
        verify($aliases)->notEmpty();
        verify($aliases)->count(1);
        verify($aliases)->hasKey('dummy');
        verify($aliases['dummy'])->equals(Dummy::class);
        verify($aliases)->hasntKey(Dummy::class);
    }

    /**
     * @return void
     */
    public function testItCanCreateFactoriesForInvokables(): void
    {
        $this->tester->assertClassHasMethod('createFactoriesForInvokables', Manager::class);
        $this->tester->assertClassMethodIsPrivate('createFactoriesForInvokables', Manager::class);

        $factories = $this->tester->invokeMethod($this->manager, 'createFactoriesForInvokables', [[
            Dummy::class => Dummy::class,
            'dummy'      => Dummy::class,
        ]]);
        verify($factories)->array();
        verify($factories)->notEmpty();
        verify($factories)->count(1);
        verify($factories)->hasKey(Dummy::class);
        verify($factories)->contains(InvokableFactory::class);
        verify($factories)->hasntKey('dummy');
    }

    /**
     * @return void
     */
    public function testItCanResolveAliases(): void
    {
        $this->tester->assertClassHasMethod('resolveAliases', Manager::class);
        $this->tester->assertClassMethodIsPrivate('resolveAliases', Manager::class);

        try {
            $this->tester->invokeMethod($this->manager, 'resolveAliases', [[
                'baz' => InvokableObject::class,
                'grault' => 'baz',
            ]]);
        } catch (Exception $e) {
            $this->fail();
        }
        verify(true)->true();
    }

    /**
     * depends testItCanResolveAliases
     *
     * @return void
     */
    public function testResolveAliasesThrowsAnExceptionOnCyclicAliases(): void
    {
        $this->expectException(CyclicAliasException::class);
        new Manager([
            'aliases' => [
                'foo' => 'foo',
            ],
        ]);
    }

    /**
     * @depends testItCanResolveAliases
     *
     * @return void
     */
    public function testItCanResolveNewAliases(): void
    {
        $this->tester->assertClassHasMethod('resolveNewAliasesWithPreviouslyResolvedAliases', Manager::class);
        $this->tester->assertClassMethodIsPrivate('resolveNewAliasesWithPreviouslyResolvedAliases', Manager::class);

        $manager = new Manager([
            'aliases' => [
                'thud' => InvokableObject::class,
                'foo_bar' => Dummy::class,
            ],
        ]);

        $this->tester->invokeMethod($manager, 'resolveAliases', [[
            'waldo' => 'foo_bar',
        ]]);

        try {
            $this->tester->invokeMethod($manager, 'resolveNewAliasesWithPreviouslyResolvedAliases', [[
                'waldo' => Dummy::class,
            ]]);
        } catch (Exception $e) {
            $this->fail();
        }
        verify(true)->true();
    }

    /**
     * @depends testItCanResolveAliases
     * @depends testItCanResolveNewAliases
     *
     * @return void
     */
    public function testItCanConfigureAliases(): void
    {
        $this->tester->assertClassHasMethod('configureAliases', Manager::class);
        $this->tester->assertClassMethodIsPrivate('configureAliases', Manager::class);

        try {
            $this->tester->invokeMethod($this->manager, 'configureAliases', [[
                'fred' => 'foo_bar'
            ]]);
        } catch (Exception $e) {
            $this->fail();
        }
        verify(true)->true();
    }

    /**
     * @return void
     */
    public function testItCanResolveInitializers(): void
    {
        $this->tester->assertClassHasMethod('resolveInitializers', Manager::class);
        $this->tester->assertClassMethodIsPrivate('resolveInitializers', Manager::class);

        try {
            $this->tester->invokeMethod($this->manager, 'resolveInitializers', [[
                DummyInitializer::class,
                (new DummyInitializer()),
            ]]);
        } catch (Exception $e) {
            $this->fail();
        }
        verify(true)->true();
    }

    /**
     * @depends testItCanResolveInitializers
     *
     * @return void
     */
    public function testResolveInitializersThrowsAnExceptionWhenInitializerClassDoesNotExist(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->tester->invokeMethod($this->manager, 'resolveInitializers', [[
            FailingPluginManager::class,
        ]]);
    }

    /**
     * @depends testItCanResolveInitializers
     *
     * @return void
     */
    public function testResolveInitializersThrowsAnExceptionWhenInitializerIsNotCallable(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->tester->invokeMethod($this->manager, 'resolveInitializers', [[
            (new FailingModel()),
        ]]);
    }

    /**
     * @return void
     */
    public function testItCanCheckANamedServiceOrFactoryExists(): void
    {
        $serviceExist = $this->manager->has('foo');
        verify($serviceExist)->bool();
        verify($serviceExist)->true();

        $serviceExist = $this->manager->has('thud');
        verify($serviceExist)->bool();
        verify($serviceExist)->false();

        $factoryExists = $this->manager->has(InvokableObject::class);
        verify($factoryExists)->bool();
        verify($factoryExists)->true();

        $factoryExists = $this->manager->has(DummyInitializer::class);
        verify($factoryExists)->bool();
        verify($factoryExists)->false();
    }

    /**
     * @depends testItCanCheckANamedServiceOrFactoryExists
     *
     * @return void
     */
    public function testHasThrowsExceptionWhenInputIsNotAString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->manager->has(['foo']);
    }

    /**
     * @return void
     */
    public function testItCanGetTheFactory(): void
    {
        $factory = $this->manager->getFactory(InvokableObject::class);
        verify($factory)->object();
        verify($factory)->isInstanceOf(SampleFactory::class);
    }

    /**
     * @depends testItCanGetTheFactory
     *
     * @return void
     */
    public function testGetFactoryThrowsAnExceptionWhenFactoryCanNotBeFound(): void
    {
        $this->expectException(ServiceNotFoundException::class);
       $this->manager->getFactory(DummyInitializer::class);
    }

    /**
     * @depends testItCanGetTheFactory
     *
     * @return void
     */
    public function testItCanCreateAnInstance(): void
    {
        $createdInstance = $this->manager->doCreate(InvokableObject::class, ['optionName' => 'optionValue']);
        verify($createdInstance)->object();
        verify($createdInstance)->isInstanceOf(InvokableObject::class);
    }

    /**
     * @depends testItCanCreateAnInstance
     *
     * @return void
     */
    public function testDoCreateThrowsExceptionWhenServiceCanNotBeCreated(): void
    {
        $this->expectException(ServiceNotCreatedException::class);
        $this->manager->doCreate(DummyInitializer::class);
    }

    /**
     * @depends testItCanCreateAnInstance
     *
     * @return void
     */
    public function testItCanGetGetANamedService(): void
    {
        $service = $this->manager->get('foo');
        verify($service)->object();
        verify($service)->isInstanceOf(DummyService::class);

        $fooBar = $this->manager->get('foo_bar');
        verify($fooBar)->object();
        verify($fooBar)->isInstanceOf(InvokableObject::class);

        $corge = $this->manager->get('corge');
        verify($corge)->object();
        verify($corge)->isInstanceOf(InvokableObject::class);

        verify($corge)->notSame($fooBar);

        $grault = $this->manager->get('corge');
        verify($grault)->object();
        verify($grault)->isInstanceOf(InvokableObject::class);

        verify($grault)->same($corge);
    }

    /**
     * @depends testItCanCreateAnInstance
     *
     * @return void
     */
    public function testItCanBuildANamedService(): void
    {
        $foo = $this->manager->build('foo_bar');
        verify($foo)->object();
        verify($foo)->isInstanceOf(InvokableObject::class);

        $bar = $this->manager->build('foo_bar');
        verify($bar)->object();
        verify($bar)->isInstanceOf(InvokableObject::class);

        verify($bar)->notSame($foo);
    }

    /**
     * @depends testItCanValidateOverrides
     * @depends testItCanCreateAliasesForInvokables
     * @depends testItCanCreateFactoriesForInvokables
     * @depends testItCanConfigureAliases
     * @depends testItCanResolveAliases
     * @depends testItCanResolveInitializers
     *
     * @return void
     */
    public function testItCanConfigure(): void
    {
        $this->traitTestItCanConfigure();

        try {
            $this->manager->configure([
                'aliases' => [
                    'baz' => Dummy::class,
                    'dummy' => 'Dummy',
                ],
                'factories' => [
                    SimpleCollection::class => DummyFactory::class,
                ],
                'initializers' => [
                    SecondDummyInitializer::class,
                ],
                'invokables' => [
                    'simpleModel' => SimpleModel::class,
                ],
                'services' => [
                    'corge' => DummyService::class,
                ],
            ]);
        } catch (Exception $e) {
            $this->fail();
        }
        verify(true)->true();
    }

    /**
     * @depends testItCanConfigure
     * @depends testItCanCheckANamedServiceOrFactoryExists
     * @depends testItCanGetGetANamedService
     *
     * @return void
     */
    public function testItCanSetAService(): void
    {
        $this->manager->setService('baz', (new DummyService()));

        verify($this->manager->has('baz'))->true();
        verify($this->manager->get('baz'))->isInstanceOf(DummyService::class);
    }

    /**
     * @depends testItCanConfigure
     * @depends testItCanCheckANamedServiceOrFactoryExists
     * @depends testItCanGetTheFactory
     *
     * @return void
     */
    public function testItCanSetAFactory(): void
    {
        $this->manager->setFactory(SimpleModel::class, SampleFactory::class);

        verify($this->manager->has(SimpleModel::class));
        verify($this->manager->getFactory(SimpleModel::class))->isInstanceOf(SampleFactory::class);
    }

    /**
     * @depends testItCanConfigure
     * @depends testItCanCheckANamedServiceOrFactoryExists
     *
     * @return void
     */
    public function testItCanSetAnAlias(): void
    {
        $this->manager->setAlias('fred', InvokableObject::class);

        verify($this->manager->has('fred'))->true();
    }

    /**
     * @depends testItCanConfigure
     *
     * @return void
     */
    public function testItCanAddAnInitializer(): void
    {
        try {
            $this->manager->addInitializer(new SecondDummyInitializer());
        } catch (Exception $e) {
            $this->fail();
        }
        verify(true)->true();
    }


}
