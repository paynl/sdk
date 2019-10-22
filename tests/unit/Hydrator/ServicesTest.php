<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\{
    Exception\InvalidArgumentException,
    Hydrator\Services as ServicesHydrator,
    Model\Services,
    Model\Service
};
use Zend\Hydrator\HydratorInterface;
use Exception;

/**
 * Class ServicesTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class ServicesTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new ServicesHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldAcceptAServicesModel(): void
    {
        $hydrator = new ServicesHydrator();
        expect($hydrator->hydrate(['services' => []], new Services()))->isInstanceOf(Services::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new ServicesHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new ServicesHydrator();
        $services = $hydrator->hydrate([
            'services' => [
                [
                    'id'          => 'SL-0000-0000',
                    'name'        => 'First serve',
                    'description' => 'Ace!',
                    'testMode'    => 0,
                    'secret'      => 'fksdrewu84',
                    'createdAt'   => '2019-10-22T13:32:00+02:00',
                ],
            ],
        ], new Services());

        expect($services->getServices())->array();
        expect($services->getServices())->count(1);
        expect($services->getServices())->containsOnlyInstancesOf(Service::class);
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new ServicesHydrator();
        $services = $hydrator->hydrate([
            'services' => [
                [
                    'id'          => 'SL-0000-0000',
                    'name'        => 'First serve',
                    'description' => 'Ace!',
                    'testMode'    => 0,
                    'secret'      => 'fksdrewu84',
                    'createdAt'   => '2019-10-22T13:32:00+02:00',
                ],
            ],
        ], new Services());

        $data = $hydrator->extract($services);
        $this->assertIsArray($data);
        verify($data)->hasKey('services');

        expect($data['services'])->array();
        expect($data['services'])->count(1);
        expect($data['services'])->containsOnlyInstancesOf(Service::class);
    }
}
