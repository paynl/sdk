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
    public function testItShouldAcceptAStatisticsModel(): void
    {
        $hydrator = new StatisticsHydrator();
        expect($hydrator->hydrate([], new Statistics()))->isInstanceOf(Statistics::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new StatisticsHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new StatisticsHydrator();
        $statistics = $hydrator->hydrate([
            'promoterId' => '10',
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
        expect($statistics->getPromoterId())->equals('10');
        expect($statistics->getInfo())->string();
        expect($statistics->getInfo())->equals('test string');
        expect($statistics->getTool())->string();
        expect($statistics->getTool())->equals('statistics tool');
        expect($statistics->getExtra1())->string();
        expect($statistics->getExtra1())->equals('1');
        expect($statistics->getExtra2())->string();
        expect($statistics->getExtra2())->equals('2');
        expect($statistics->getExtra3())->string();
        expect($statistics->getExtra3())->equals('3');
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
            'promoterId' => '10',
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
        expect($data['promoterId'])->equals('10');
        expect($data['info'])->string();
        expect($data['info'])->equals('test string');
        expect($data['tool'])->string();
        expect($data['tool'])->equals('statistics tool');
        expect($data['extra1'])->string();
        expect($data['extra1'])->equals('1');
        expect($data['extra2'])->string();
        expect($data['extra2'])->equals('2');
        expect($data['extra3'])->string();
        expect($data['extra3'])->equals('3');
        expect($data['transferData'])->array();
        expect($data['transferData'])->containsOnly('string');
        expect($data['transferData'])->count(1);
    }
}
