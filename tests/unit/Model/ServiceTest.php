<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    Links,
    Service
};
use Exception, JsonSerializable;

/**
 * Class ServiceTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ServiceTest extends UnitTest
{
    /**
     * @var Service
     */
    protected $service;

    public function _before(): void
    {
        $this->service = new Service();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->service)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->service)->isNotInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItUsesLinksTrait(): void
    {
        verify(in_array(LinksTrait::class, class_uses($this->service), true))->true();
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        expect($this->service->setId('SL-0000-0000'))->isInstanceOf(Service::class);
    }

    /**
     * @depends testItCanSetAnId
     *
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $this->service->setId('SL-0000-0000');

        verify($this->service->getId())->string();
        verify($this->service->getId())->notEmpty();
        verify($this->service->getId())->equals('SL-0000-0000');
    }

    /**
     * @return void
     */
    public function testItCanSetAName(): void
    {
        expect($this->service->setName('Service 1'))->isInstanceOf(Service::class);
    }

    /**
     * @depends testItCanSetAName
     *
     * @return void
     */
    public function testItCanGetAName(): void
    {
        $this->service->setName('Service 1');

        verify($this->service->getName())->string();
        verify($this->service->getName())->notEmpty();
        verify($this->service->getName())->equals('Service 1');
    }

    /**
     * @return void
     */
    public function testItCanSetADescription(): void
    {
        expect($this->service->setDescription('Service description'))->isInstanceOf(Service::class);
    }

    /**
     * @depends testItCanSetADescription
     *
     * @return void
     */
    public function testItCanGetADescription(): void
    {
        verify($this->service->getDescription())->string();
        verify($this->service->getDescription())->equals('');

        $this->service->setDescription('Service description');

        verify($this->service->getDescription())->string();
        verify($this->service->getDescription())->notEmpty();
        verify($this->service->getDescription())->equals('Service description');
    }

    /**
     * @return void
     */
    public function testItCanSetTestMode(): void
    {
        expect($this->service->setTestMode(1))->isInstanceOf(Service::class);
    }

    /**
     * @depends testItCanSetTestMode
     *
     * @return void
     */
    public function testItCanGetTestMode(): void
    {
        verify($this->service->isTestMode())->int();
        verify($this->service->isTestMode())->equals(0);

        $this->service->setTestMode(1);

        verify($this->service->isTestMode())->int();
        verify($this->service->isTestMode())->notEmpty();
        verify($this->service->isTestMode())->equals(1);
    }

    /**
     * @return void
     */
    public function testItCanSetASecret(): void
    {
        expect($this->service->setSecret('uZ3Th4F0rc3!'))->isInstanceOf(Service::class);
    }

    /**
     * @depends testItCanSetASecret
     *
     * @return void
     */
    public function testItCanGetASecret(): void
    {
        verify($this->service->getSecret())->string();
        verify($this->service->getSecret())->equals('');

        $this->service->setSecret('uZ3Th4F0rc3!');

        verify($this->service->getSecret())->string();
        verify($this->service->getSecret())->notEmpty();
        verify($this->service->getSecret())->equals('uZ3Th4F0rc3!');
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetACreatedAt(): void
    {
        expect($this->service->setCreatedAt(new DateTime()))->isInstanceOf(Service::class);
    }

    /**
     * @depends testItCanSetACreatedAt
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetACreatedAt(): void
    {
        verify($this->service->getCreatedAt())->null();

        $this->service->setCreatedAt(new DateTime());

        verify($this->service->getCreatedAt())->notEmpty();
        verify($this->service->getCreatedAt())->isInstanceOf(DateTime::class);
    }
}
