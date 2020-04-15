<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Lib\CollectionTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{
    LinksTrait,
    Service,
    Services
};

use Mockery;
use PayNL\Sdk\Common\DateTime;

/**
 * Class ServicesTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ServicesTest extends UnitTest
{
    use ModelTestTrait, CollectionTestTrait {
        testItCanBeAccessedLikeAnArray as traitTestItCanBeAccessedLikeAnArray;
    }

    /**
     * @var Services
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsTotalCollection();
        $this->model = new Services();
    }

    /**
     * @return void
     */
    public function testItUsesLinksTrait(): void
    {
        $this->tester->assertObjectUsesTrait($this->model, LinksTrait::class);
    }

    /**
     * @return Service
     */
    private function getServiceMock(): Service
    {
        return $this->tester->grabService('modelManager')->get('Service');
    }

    /**
     * @return Service
     */
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

    /**
     * @return Service
     */
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
     * @return void
     */
    public function testItCanAddService(): void
    {
        $this->tester->assertObjectHasMethod('addService', $this->model);
        $this->tester->assertObjectMethodIsPublic('addService', $this->model);

        verify($this->model->addService($this->getFirstService()))
            ->isInstanceOf(Services::class);
    }

    /**
     * @depends testItCanAddService
     *
     * @return void
     */
    public function testItCanSetServices(): void
    {
        $this->tester->assertObjectHasMethod('setServices', $this->model);
        $this->tester->assertObjectMethodIsPublic('setServices', $this->model);

        verify($this->model->setServices([]))->isInstanceOf(Services::class);
    }

    /**
     * @depends testItCanSetServices
     *
     * @return void
     */
    public function testItCanGetServices(): void
    {
        $this->tester->assertObjectHasMethod('getServices', $this->model);
        $this->tester->assertObjectMethodIsPublic('getServices', $this->model);

        $this->model->addService($this->getFirstService());

        verify($this->model->getServices())->array();
        verify($this->model->getServices())->count(1);
    }

    /**
     * @depends testItCanSetServices
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        $this->traitTestItCanBeAccessedLikeAnArray();

        $firstService = $this->getFirstService();
        $this->model->setServices([ $firstService ])->setTotal(1);

        // offsetExists
        verify(isset($this->model[$firstService->getId()]))->true();
        verify(isset($this->model['non_existing_key']))->false();

        // offsetGet
        verify($this->model[$firstService->getId()])->isInstanceOf(Service::class);

        // offsetSet
        $secondService = $this->getSecondService();
        $this->model[$secondService->getId()] = $secondService;
        verify($this->model)->hasKey($secondService->getId());
        verify($this->model)->count(2);

        // offsetUnset
        unset($this->model[$firstService->getId()]);
        verify($this->model)->count(1);
        verify($this->model)->hasntKey($firstService->getId());
    }
}
