<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Validator;

use Codeception\Lib\ManagerTestTrait;
use CodeCeption\Test\Unit as UnitTest;
use PayNL\Sdk\Application\Application;
use PayNL\Sdk\Validator\Manager;
use PayNL\Sdk\Service\AbstractPluginManager;
use PayNL\Sdk\Validator\Qr\Decode;
use PayNL\Sdk\Validator\RequiredMembers;
use PayNL\Sdk\Validator\ValidatorInterface;

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

    private $application;

    /**
     * @return void
     */
    public function _before(): void
    {
        /** @var Manager $manager */
        $this->manager = new Manager();

        /** @var Application $application */
        $this->application = Application::init($this->tester->getConfig());
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
        verify($instanceOf)->equals(ValidatorInterface::class);
    }

    /**
     * @return void
     */
    public function testItCanGetCustomValidatorByRequest(): void
    {
        $this->application->setRequest('DecodeQr');
        $options =  $this->application->getRequest()->getOptions();
        $options['validator'] = Decode::class;
        $this->application->getRequest()->setOptions($options);

        $validator = $this->manager->getValidatorByRequest($this->application->getRequest());

        $this->assertInstanceOf(Decode::class, $validator);
    }

    /**
     * @return void
     */
    public function testItCanGetDefaultValidatorByRequest(): void
    {
        $this->application->setRequest('GetCurrency', ['currencyId' => 'EUR'], [], ['Currency' => []]);

        $request = $this->application->getRequest();

        $validator = $request->getValidatorManager()->getValidatorByRequest($request);

        $this->assertInstanceOf(RequiredMembers::class, $validator);
    }
}
