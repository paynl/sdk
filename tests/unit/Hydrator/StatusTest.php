<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Hydrator\Status as StatusHydrator;
use PayNL\Sdk\Model\Status;
use Zend\Hydrator\HydratorInterface;
use PayNL\Sdk\DateTime;

/**
 * Class StatusTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class StatusTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new StatusHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldOnlyAcceptSpecificModel(): void
    {
        $hydrator = new StatusHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());

        expect($hydrator->hydrate([], new Status()))->isInstanceOf(Status::class);
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new StatusHydrator();
        $status = $hydrator->hydrate([
            'code'   => 316,
            'name'   => 'Processed',
            'date'   => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
            'reason' => 'Because it can!',
        ], new Status());

        expect($status->getCode())->string();
        expect($status->getCode())->equals('316');
        expect($status->getName())->string();
        expect($status->getName())->equals('Processed');
        expect($status->getDate())->isInstanceOf(DateTime::class);
        expect($status->getReason())->string();
        expect($status->getReason())->equals('Because it can!');
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new StatusHydrator();
        $status = $hydrator->hydrate([
            'code'   => 316,
            'name'   => 'Processed',
            'date'   => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
            'reason' => 'Because it can!',
        ], new Status());

        $data = $hydrator->extract($status);
        $this->assertIsArray($data);
        verify($data)->hasKey('code');
        verify($data)->hasKey('name');
        verify($data)->hasKey('date');
        verify($data)->hasKey('reason');

        expect($data['code'])->string();
        expect($data['code'])->equals('316');
        expect($data['name'])->string();
        expect($data['name'])->equals('Processed');
        expect($data['date'])->isInstanceOf(DateTime::class);
        expect($data['reason'])->string();
        expect($data['reason'])->equals('Because it can!');
    }
}