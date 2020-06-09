<?php

declare(strict_types=1);

namespace Tests\PayNL\Sdk\unit\Model\Member;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    Statistics,
    Member\StatisticsAwareTrait
};
use UnitTester,
    ReflectionException;

/**
 * Class StatisticsAwareTraitTest
 *
 * @package Tests\PayNL\Sdk\unit\Model\Member
 */
class StatisticsAwareTraitTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanSetStatistics(): void
    {
        /** @var StatisticsAwareTrait $traitCls */
        $traitCls = $this->getMockForTrait(StatisticsAwareTrait::class);

        $this->tester->assertObjectHasMethod('setStatistics', $traitCls);
        $this->tester->assertObjectMethodIsPublic('setStatistics', $traitCls);

        /** @var Statistics $statistics */
        $statistics = $this->tester->grabService('modelManager')->get('Statistics');

        $result = $traitCls->setStatistics($statistics);
        verify($result)->isInstanceOf(get_class($traitCls));
        verify($result)->same($traitCls);
    }

    /**
     * @depends testItCanSetStatistics
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanGetStatistics(): void
    {
        /** @var StatisticsAwareTrait $traitCls */
        $traitCls = $this->getMockForTrait(StatisticsAwareTrait::class);

        $this->tester->assertObjectHasMethod('getStatistics', $traitCls);
        $this->tester->assertObjectMethodIsPublic('getStatistics', $traitCls);

        $statistics = $traitCls->getStatistics();
        verify($statistics)->isInstanceOf(Statistics::class);
        verify($statistics->getObject())->isEmpty();
        verify($statistics->getInfo())->isEmpty();
        verify($statistics->getTool())->isEmpty();
        verify($statistics->getExtra1())->isEmpty();
        verify($statistics->getExtra2())->isEmpty();
        verify($statistics->getExtra3())->isEmpty();

        /** @var Statistics $statisticsModel */
        $statisticsModel = $this->tester->grabService('modelManager')->get('Statistics');
        $statisticsModel->setObject('foo');
        $statisticsModel->setInfo('bar');
        $statisticsModel->setTool('baz');
        $statisticsModel->setExtra1('qux');
        $statisticsModel->setExtra2('quux');
        $statisticsModel->setExtra3('corge');
        $traitCls->setStatistics($statisticsModel);

        $result = $traitCls->getStatistics();
        verify($result)->isInstanceOf(Statistics::class);
        verify($result)->same($statisticsModel);
        verify($result)->notSame($statistics);
    }
}
