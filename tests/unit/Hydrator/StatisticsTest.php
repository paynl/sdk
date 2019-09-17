<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Hydrator\Statistics as StatisticsHydrator;
use PayNL\Sdk\Model\Statistics;
use Zend\Hydrator\HydratorInterface;

/**
 * Class StatisticsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class StatisticsTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new StatisticsHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldOnlyAcceptSpecificModel(): void
    {
        $hydrator = new StatisticsHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());

        expect($hydrator->hydrate([], new Statistics()))->isInstanceOf(Statistics::class);
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new StatisticsHydrator();
        $statistics = $hydrator->hydrate([
            'promoterId' => '0',
            'info' => 'test string',
            'tool' => 'statistics tool',
            'extra1' => '1',
            'extra2' => '2',
            'extra3' => '3',
            'transferData' => [
                'string 1',
            ],
        ], new Statistics());

        expect($statistics->getPromoterId())->string();
        expect($statistics->getInfo())->string();
        expect($statistics->getTool())->string();
        expect($statistics->getExtra1())->string();
        expect($statistics->getExtra2())->string();
        expect($statistics->getExtra3())->string();
        expect($statistics->getTransferData())->array();
        expect($statistics->getTransferData())->containsOnly('string');
        expect($statistics->getTransferData())->count(1);
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new StatisticsHydrator();
        $statistics = $hydrator->hydrate([
            'promoterId' => '0',
            'info' => 'test string',
            'tool' => 'statistics tool',
            'extra1' => '1',
            'extra2' => '2',
            'extra3' => '3',
            'transferData' => [
                'string 1',
            ],
        ], new Statistics());

        $data = $hydrator->extract($statistics);
        $this->assertIsArray($data);
        verify($data)->hasKey('promoterId');
        verify($data)->hasKey('info');
        verify($data)->hasKey('tool');
        verify($data)->hasKey('extra1');
        verify($data)->hasKey('extra2');
        verify($data)->hasKey('extra3');
        verify($data)->hasKey('transferData');

        expect($data['promoterId'])->string();
        expect($data['info'])->string();
        expect($data['tool'])->string();
        expect($data['extra1'])->string();
        expect($data['extra2'])->string();
        expect($data['extra3'])->string();
        expect($data['transferData'])->array();
        expect($data['transferData'])->containsOnly('string');
        expect($data['transferData'])->count(1);
    }
}
