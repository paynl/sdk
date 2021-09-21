<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Lib\CollectionTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{
    Directdebits,
    Directdebit
};
use TypeError;

/**
 * Class DirectdebitsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class DirectdebitsTest extends UnitTest
{
    use ModelTestTrait, CollectionTestTrait {
        testItCanBeAccessedLikeAnArray as traitTestItCanBeAccessedLikeAnArray;
        testItCanGetCollectionName as traitTestItCanGetCollectionName;
    }

    /**
     * @var Directdebits
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new Directdebits();
    }

    /**
     * @param string $id
     *
     * @return Directdebit
     */
    private function getMockDirectdebit(string $id): Directdebit
    {
        /** @var Directdebit $directdebit */
        $directdebit = $this->tester->grabService('modelManager')->build(Directdebit::class);
        $directdebit->setId($id);
        return $directdebit;
    }

    /**
     * @return void
     */
    public function testItCanAddDirectdebit(): void
    {
        $this->tester->assertObjectHasMethod('addDirectdebit', $this->model);
        $this->tester->assertObjectMethodIsPublic('addDirectdebit', $this->model);

        $mockDirectdebit = $this->getMockDirectdebit('foo');

        $directdebits = $this->model->addDirectdebit($mockDirectdebit);
        verify($directdebits)->object();
        verify($directdebits)->same($this->model);
        verify($directdebits)->hasKey($mockDirectdebit->getId());
    }

    /**
     * @depends testItCanAddDirectdebit
     *
     * @return void
     */
    public function testItCanSetDirectdebits(): void
    {
        $this->tester->assertObjectHasMethod('setDirectdebits', $this->model);
        $this->tester->assertObjectMethodIsPublic('setDirectdebits', $this->model);

        $mockDirectdebit = $this->getMockDirectdebit('foo');

        $directdebits = $this->model->setDirectdebits([$mockDirectdebit]);
        verify($directdebits)->object();
        verify($directdebits)->same($this->model);
        verify($directdebits)->containsOnlyInstancesOf(Directdebit::class);
        verify($directdebits)->notEmpty();
        verify($directdebits)->count(1);

        $directdebits = $this->model->setDirectdebits([
            $this->getMockDirectdebit('bar'),
            $this->getMockDirectdebit('baz'),
        ]);
        verify($directdebits)->object();
        verify($directdebits)->same($this->model);
        verify($directdebits)->containsOnlyInstancesOf(Directdebit::class);
        verify($directdebits)->count(2);
        verify($directdebits)->notContains($mockDirectdebit);
    }

    /**
     * @depends testItCanAddDirectdebit
     * @depends testItCanSetDirectdebits
     *
     * @return void
     */
    public function testSetDirectdebitsThrowsTypeError(): void
    {
        $this->expectException(TypeError::class);
        $this->model->setDirectdebits([$this->getMockDirectdebit('foo'), []]);
    }

    /**
     * @depends testItCanAddDirectdebit
     * @depends testItCanSetDirectdebits
     *
     * @return void
     */
    public function testItCanSetEmptyDirectdebits(): void
    {
        $directdebits = $this->model->setDirectdebits([]);
        verify($directdebits)->isInstanceOf(Directdebits::class);
        verify($directdebits)->same($this->model);
        verify($directdebits)->count(0);
    }

    /**
     * @depends testItCanSetDirectdebits
     *
     * @return void
     */
    public function testItCanGetDirectdebits(): void
    {
        $this->tester->assertObjectHasMethod('getDirectdebits', $this->model);
        $this->tester->assertObjectMethodIsPublic('getDirectdebits', $this->model);

        $mockDirectdebit = $this->getMockDirectdebit('foo');

        $this->model->setDirectdebits([$mockDirectdebit]);
        $directdebits = $this->model->getDirectdebits();
        verify($directdebits)->array();
        verify($directdebits)->count(1);
        verify($directdebits)->hasKey('foo');
        verify($directdebits)->containsOnlyInstancesOf(Directdebit::class);
    }

    /**
     * @depends testItCanSetDirectdebits
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        $this->traitTestItCanBeAccessedLikeAnArray();

        $this->model->setDirectdebits([ $this->getMockDirectdebit('foo') ]);

        // offsetExists
        verify(isset($this->model['foo']))->true();
        verify(isset($this->model['bar']))->false();

        // offsetGet
        verify($this->model['foo'])->isInstanceOf(Directdebit::class);

        // offsetSet
        $this->model['baz'] = $this->getMockDirectdebit('baz');
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
        verify($this->model->getCollectionName())->equals('directdebits');
    }
}
