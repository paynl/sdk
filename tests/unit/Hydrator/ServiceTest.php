<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Hydrator\Service as ServiceHydrator;
use PayNL\Sdk\Model\Service;
use Zend\Hydrator\HydratorInterface;
use PayNL\Sdk\DateTime;

/**
 * Class ServiceTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class ServiceTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new ServiceHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldAcceptAServiceModel(): void
    {
        $hydrator = new ServiceHydrator();
        expect($hydrator->hydrate([], new Service()))->isInstanceOf(Service::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new ServiceHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new ServiceHydrator();
        $service = $hydrator->hydrate([
            'id'          => 'SL-0000-0000',
            'name'        => 'First serve',
            'description' => 'Ace!',
            'testMode'    => 0,
            'secret'      => 'fksdrewu84',
            'createdAt'   => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
        ], new Service());

        expect($service->getId())->string();
        expect($service->getId())->equals('SL-0000-0000');
        expect($service->getName())->string();
        expect($service->getName())->equals('First serve');
        expect($service->getDescription())->string();
        expect($service->getDescription())->equals('Ace!');
        expect($service->getTestMode())->int();
        expect($service->getTestMode())->equals(0);
        expect($service->getSecret())->string();
        expect($service->getSecret())->equals('fksdrewu84');
        expect($service->getCreatedAt())->isInstanceOf(DateTime::class);
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new ServiceHydrator();
        $service = $hydrator->hydrate([
            'id'          => 'SL-0000-0000',
            'name'        => 'First serve',
            'description' => 'Ace!',
            'testMode'    => 0,
            'secret'      => 'fksdrewu84',
            'createdAt'   => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
        ], new Service());

        $data = $hydrator->extract($service);
        $this->assertIsArray($data);
        verify($data)->hasKey('id');
        verify($data)->hasKey('name');
        verify($data)->hasKey('description');
        verify($data)->hasKey('testMode');
        verify($data)->hasKey('secret');
        verify($data)->hasKey('createdAt');

        expect($data['id'])->string();
        expect($data['id'])->equals('SL-0000-0000');
        expect($data['name'])->string();
        expect($data['name'])->equals('First serve');
        expect($data['description'])->string();
        expect($data['description'])->equals('Ace!');
        expect($data['testMode'])->int();
        expect($data['testMode'])->equals(0);
        expect($data['secret'])->string();
        expect($data['secret'])->equals('fksdrewu84');
        expect($data['createdAt'])->isInstanceOf(DateTime::class);
    }
}
