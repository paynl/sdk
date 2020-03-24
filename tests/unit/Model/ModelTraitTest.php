<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelAwareTrait,
    ModelInterface
};
use UnitTester,
    ReflectionException,
    Exception
;

/**
 * Class ModelTraitTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ModelTraitTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @throws Exception
     *
     * @return ModelInterface
     */
    private function getMockModel(): ModelInterface
    {
        /** @var ModelInterface $model */
        $model = $this->makeEmpty(ModelInterface::class);
        return $model;
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetModel(): void
    {
        /** @var ModelAwareTrait $traitCls */
        $traitCls = $this->getMockForTrait(ModelAwareTrait::class);
        $this->tester->assertObjectHasMethod('setModel', $traitCls);

        $instance = $traitCls->setModel($this->getMockModel());
        verify($instance)->object();
        verify($instance)->same($traitCls);
    }

    /**
     * @depends testItCanSetModel
     *
     * @throws ReflectionException
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetLinks(): void
    {
        /** @var ModelAwareTrait $traitCls */
        $traitCls = $this->getMockForTrait(ModelAwareTrait::class);
        $this->tester->assertObjectHasMethod('getModel', $traitCls);

        $model = $traitCls->getModel();
        verify($model)->null();

        $mockModel = $this->getMockModel();
        $traitCls->setModel($mockModel);
        $model = $traitCls->getModel();
        verify($model)->object();
        verify($model)->isInstanceOf(ModelInterface::class);
        verify($model)->same($mockModel);
    }
}
