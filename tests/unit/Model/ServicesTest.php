<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    LinksTrait,
    ModelInterface,
    Service,
    Services
};

use JsonSerializable, Countable, ArrayAccess, IteratorAggregate, Exception;
use Mockery;
use PayNL\Sdk\Common\AbstractTotalCollection;
use UnitTester;
use PayNL\Sdk\Common\DateTime;

/**
 * Class ServicesTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ServicesTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @var Services
     */
    protected $services;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->services = new Services();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->services)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testItIsAnAbstractCollection(): void
    {
        verify($this->services)->isInstanceOf(AbstractTotalCollection::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->services)->isNotInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItUsesLinksTrait(): void
    {
        verify(in_array(LinksTrait::class, class_uses($this->services), true))->true();
    }

    private function getServiceMock(): Service
    {
        return $this->tester->grabService('modelManager')->get('Service');
    }

    private function getFirstService(): Service
    {
        return ($this->getServiceMock())
            ->setId('SL-0000-0000')
            ->setName('First serve')
            ->setDescription('Ace!')
            ->setTestMode(false)
            ->setSecret('fksdrewu84')
            ->setCreatedAt(Mockery::mock(DateTime::class));
    }

    private function getSecondService(): Service
    {
        return ($this->getServiceMock())
            ->setId('SL-0000-0001')
            ->setName('Second serve')
            ->setDescription('Ace!')
            ->setTestMode(false)
            ->setSecret('fksdrewu84')
            ->setCreatedAt(Mockery::mock(DateTime::class));
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanAddService(): void
    {
        verify(method_exists($this->services, 'addService'))->true();
        verify($this->services->addService($this->getFirstService()))
            ->isInstanceOf(Services::class);
    }

    /**
     * @depends testItCanAddService
     *
     * @return void
     */
    public function testItCanSetServices(): void
    {
        verify(method_exists($this->services, 'setServices'))->true();
        verify($this->services->setServices([]))->isInstanceOf(Services::class);
    }

    /**
     * @depends testItCanSetServices
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetServices(): void
    {
        verify(method_exists($this->services, 'getServices'))->true();

        $this->services->addService($this->getFirstService());

        verify($this->services->getServices())->array();
        verify($this->services->getServices())->count(1);
    }

    /**
     * @return void
     */
    public function testItCanSetTotal(): void
    {
        verify(method_exists($this->services, 'setTotal'))->true();
        verify($this->services->setTotal(1))->isInstanceOf(Services::class);
    }

    /**
     * @depends testItCanSetTotal
     *
     * @return void
     */
    public function testItCanGetTotal(): void
    {
        $this->services->setTotal(1);

        verify($this->services->getTotal())->int();
        verify($this->services->getTotal())->notEmpty();
        verify($this->services->getTotal())->equals(1);
    }


    /**
     * @depends testItCanSetServices
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItIsCountable(): void
    {
        verify($this->services)->isInstanceOf(Countable::class);

        $this->services->setServices([ $this->getFirstService() ])->setTotal(1);

        verify(count($this->services))->equals(1);
    }

    /**
     * @depends testItCanSetServices
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        verify($this->services)->isInstanceOf(ArrayAccess::class);

        $firstService = $this->getFirstService();
        $this->services->setServices([ $firstService ])->setTotal(1);

        // offsetExists
        verify(isset($this->services[$firstService->getId()]))->true();
        verify(isset($this->services['non_existing_key']))->false();

        // offsetGet
        verify($this->services[$firstService->getId()])->isInstanceOf(Service::class);

        // offsetSet
        $secondService = $this->getSecondService();
        $this->services[$secondService->getId()] = $secondService;
        verify($this->services)->hasKey($secondService->getId());
        verify($this->services)->count(2);

        // offsetUnset
        unset($this->services[$firstService->getId()]);
        verify($this->services)->count(1);
        verify($this->services)->hasntKey($firstService->getId());
    }

    /**
     * @depends testItCanSetServices
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanBeIterated(): void
    {
        verify($this->services)->isInstanceOf(IteratorAggregate::class);

        $this->services->setServices([ $this->getFirstService() ])->setTotal(1);

        verify(is_iterable($this->services))->true();
    }
}
