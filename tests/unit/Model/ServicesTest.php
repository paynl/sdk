<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    Links,
    Service,
    Services
};
use PayNL\Sdk\{
    DateTime,
    TotalCollection
};
use PayNL\Sdk\Hydrator\{
    Service as ServiceHydrator,
    Links as LinksHydrator
};
use JsonSerializable, Countable, ArrayAccess, IteratorAggregate, Exception;

/**
 * Class ServicesTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ServicesTest extends UnitTest
{
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
    public function testItIsATotalCollection(): void
    {
        verify($this->services)->isInstanceOf(TotalCollection::class);
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
    public function testItCanSetLinks(): void
    {
        verify(method_exists($this->services, 'setLinks'))->true();
        verify($this->services->setLinks(new Links()))->isInstanceOf(Services::class);
    }

    /**
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testItCanGetLinks(): void
    {
        verify(method_exists($this->services, 'getLinks'))->true();

        $this->services->setLinks(
            (new LinksHydrator())->hydrate([
                [
                    'rel'  => 'self',
                    'type' => 'GET',
                    'url'  => 'http://some.url.com',
                ],
            ], new Links())
        );

        verify($this->services->getLinks())->isInstanceOf(Links::class);
        verify($this->services->getLinks())->count(1);
        verify($this->services->getLinks())->hasKey('self');
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanAddService(): void
    {
        verify(method_exists($this->services, 'addService'))->true();
        verify($this->services->addService((new ServiceHydrator())->hydrate([
            'id'          => 'SL-0000-0000',
            'name'        => 'First serve',
            'description' => 'Ace!',
            'testMode'    => 0,
            'secret'      => 'fksdrewu84',
            'createdAt'   => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
        ], new Service())))->isInstanceOf(Services::class);
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

        $this->services->addService((new ServiceHydrator())->hydrate([
            'id'          => 'SL-0000-0000',
            'name'        => 'First serve',
            'description' => 'Ace!',
            'testMode'    => 0,
            'secret'      => 'fksdrewu84',
            'createdAt'   => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
        ], new Service()));

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
        verify(method_exists($this->services, 'getTotal'))->true();

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

        $this->services->setServices([
            (new ServiceHydrator())->hydrate([
                'id'          => 'SL-0000-0000',
                'name'        => 'First serve',
                'description' => 'Ace!',
                'testMode'    => 0,
                'secret'      => 'fksdrewu84',
                'createdAt'   => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
            ], new Service()),
        ])->setTotal(1);

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

        $this->services->setServices([
            (new ServiceHydrator())->hydrate([
                'id'          => 'SL-0000-0000',
                'name'        => 'First serve',
                'description' => 'Ace!',
                'testMode'    => 0,
                'secret'      => 'fksdrewu84',
                'createdAt'   => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
            ], new Service()),
        ])->setTotal(1);

        // offsetExists
        verify(isset($this->services['SL-0000-0000']))->true();
        verify(isset($this->services['non_existing_key']))->false();

        // offsetGet
        verify($this->services['SL-0000-0000'])->isInstanceOf(Service::class);

        // offsetSet
        $this->services['SL-0000-0001'] = (new ServiceHydrator())->hydrate([
            'id'          => 'SL-0000-0001',
            'name'        => 'Second serve',
            'description' => 'Ace!',
            'testMode'    => 0,
            'secret'      => 'fksdrewu84',
            'createdAt'   => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
        ], new Service());
        verify($this->services)->hasKey('SL-0000-0001');
        verify($this->services)->count(2);

        // offsetUnset
        unset($this->services['SL-0000-0000']);
        verify($this->services)->count(1);
        verify($this->services)->hasntKey('SL-0000-0000');
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

        $this->services->setServices([
            (new ServiceHydrator())->hydrate([
                'id'          => 'SL-0000-0000',
                'name'        => 'First serve',
                'description' => 'Ace!',
                'testMode'    => 0,
                'secret'      => 'fksdrewu84',
                'createdAt'   => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
            ], new Service()),
        ])->setTotal(1);

        verify(is_iterable($this->services))->true();
    }
}
