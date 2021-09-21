<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Lib\CollectionTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{
    Trademarks,
    Trademark
};
use TypeError;

/**
 * Class TrademarksTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class TrademarksTest extends UnitTest
{
    use ModelTestTrait, CollectionTestTrait {
        testItCanBeAccessedLikeAnArray as traitTestItCanBeAccessedLikeAnArray;
        testItCanGetCollectionName as traitTestItCanGetCollectionName;
    }

    /**
     * @var Trademarks
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new Trademarks();
    }

    /**
     * @param string $id
     *
     * @return Trademark
     */
    private function getMockTrademark(string $id): Trademark
    {
        /** @var Trademark $trademark */
        $trademark = $this->tester->grabService('modelManager')->build(Trademark::class);
        $trademark->setId($id);
        return $trademark;
    }

    /**
     * @return void
     */
    public function testItCanAddTrademark(): void
    {
        $this->tester->assertObjectHasMethod('addTrademark', $this->model);
        $this->tester->assertObjectMethodIsPublic('addTrademark', $this->model);

        $mockTrademark = $this->getMockTrademark('foo');

        $trademarks = $this->model->addTrademark($mockTrademark);
        verify($trademarks)->object();
        verify($trademarks)->same($this->model);
        verify($trademarks)->hasKey($mockTrademark->getId());
    }

    /**
     * @depends testItCanAddTrademark
     *
     * @return void
     */
    public function testItCanSetTrademarks(): void
    {
        $this->tester->assertObjectHasMethod('setTrademarks', $this->model);
        $this->tester->assertObjectMethodIsPublic('setTrademarks', $this->model);

        $mockTrademark = $this->getMockTrademark('foo');

        $trademarks = $this->model->setTrademarks([$mockTrademark]);
        verify($trademarks)->object();
        verify($trademarks)->same($this->model);
        verify($trademarks)->containsOnlyInstancesOf(Trademark::class);
        verify($trademarks)->notEmpty();
        verify($trademarks)->count(1);

        $trademarks = $this->model->setTrademarks([
            $this->getMockTrademark('bar'),
            $this->getMockTrademark('baz'),
        ]);
        verify($trademarks)->object();
        verify($trademarks)->same($this->model);
        verify($trademarks)->containsOnlyInstancesOf(Trademark::class);
        verify($trademarks)->count(2);
        verify($trademarks)->notContains($mockTrademark);
    }

    /**
     * @depends testItCanAddTrademark
     * @depends testItCanSetTrademarks
     *
     * @return void
     */
    public function testSetTrademarksThrowsTypeError(): void
    {
        $this->expectException(TypeError::class);
        $this->model->setTrademarks([$this->getMockTrademark('foo'), []]);
    }

    /**
     * @depends testItCanAddTrademark
     * @depends testItCanSetTrademarks
     *
     * @return void
     */
    public function testItCanSetEmptyTrademarks(): void
    {
        $trademarks = $this->model->setTrademarks([]);
        verify($trademarks)->isInstanceOf(Trademarks::class);
        verify($trademarks)->same($this->model);
        verify($trademarks)->count(0);
    }

    /**
     * @depends testItCanSetTrademarks
     *
     * @return void
     */
    public function testItCanGetTrademarks(): void
    {
        $this->tester->assertObjectHasMethod('getTrademarks', $this->model);
        $this->tester->assertObjectMethodIsPublic('getTrademarks', $this->model);

        $mockTrademark = $this->getMockTrademark('foo');

        $this->model->setTrademarks([$mockTrademark]);
        $trademarks = $this->model->getTrademarks();
        verify($trademarks)->array();
        verify($trademarks)->count(1);
        verify($trademarks)->hasKey('foo');
        verify($trademarks)->containsOnlyInstancesOf(Trademark::class);
    }

    /**
     * @depends testItCanSetTrademarks
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        $this->traitTestItCanBeAccessedLikeAnArray();

        $this->model->setTrademarks([ $this->getMockTrademark('foo') ]);

        // offsetExists
        verify(isset($this->model['foo']))->true();
        verify(isset($this->model['bar']))->false();

        // offsetGet
        verify($this->model['foo'])->isInstanceOf(Trademark::class);

        // offsetSet
        $this->model['baz'] = $this->getMockTrademark('baz');
        verify($this->model)->hasKey('baz');
        verify($this->model)->count(2);

        // offsetUnset
        unset($this->model['foo']);
        verify($this->model)->count(1);
        verify($this->model)->hasNotKey('foo');
    }

    /**
     * @inheritDoc
     */
    public function testItCanGetCollectionName(): void
    {
        $this->traitTestItCanGetCollectionName();
        verify($this->model->getCollectionName())->equals('trademarks');
    }
}
