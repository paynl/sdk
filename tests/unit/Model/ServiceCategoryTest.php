<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\ServiceCategory;
use PayNL\Sdk\Model\ModelInterface;

/**
 * Class ServiceCategoryTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ServiceCategoryTest extends UnitTest
{
    /**
     * @var ServiceCategory
     */
    protected $serviceCategory;

    public function _before(): void
    {
        $this->serviceCategory = new ServiceCategory();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->serviceCategory)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->serviceCategory)->isNotInstanceOf(\JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        expect($this->serviceCategory->setId(1000))->isInstanceOf(ServiceCategory::class);
    }

    /**
     * @depends testItCanSetAnId
     *
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $this->serviceCategory->setId(1000);

        verify($this->serviceCategory->getId())->int();
        verify($this->serviceCategory->getId())->notEmpty();
        verify($this->serviceCategory->getId())->equals(1000);
    }

    /**
     * @return void
     */
    public function testItCanSetAName(): void
    {
        expect($this->serviceCategory->setName('Category'))->isInstanceOf(ServiceCategory::class);
    }

    /**
     * @depends testItCanSetAName
     *
     * @return void
     */
    public function testItCanGetAName(): void
    {
        $this->serviceCategory->setName('Category');

        verify($this->serviceCategory->getName())->string();
        verify($this->serviceCategory->getName())->notEmpty();
        verify($this->serviceCategory->getName())->equals('Category');
    }
}
