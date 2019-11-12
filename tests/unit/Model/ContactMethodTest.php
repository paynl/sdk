<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    ContactMethod
};
use JsonSerializable;

/**
 * Class ContactMethodTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ContactMethodTest extends UnitTest
{
    /**
     * @var ContactMethod
     */
    protected $contactMethod;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->contactMethod = new ContactMethod();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->contactMethod)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->contactMethod)->isNotInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAType(): void
    {
        expect($this->contactMethod->setType('email'))->isInstanceOf(ContactMethod::class);
    }

    /**
     * @depends testItCanSetAType
     *
     * @return void
     */
    public function testItCanGetAType(): void
    {
        $this->contactMethod->setType('email');

        verify($this->contactMethod->getType())->string();
        verify($this->contactMethod->getType())->notEmpty();
        verify($this->contactMethod->getType())->equals('email');
    }

    /**
     * @return void
     */
    public function testItCanSetAValue(): void
    {
        expect($this->contactMethod->setValue('support@pay.nl'))->isInstanceOf(ContactMethod::class);
    }

    /**
     * @depends testItCanSetAValue
     *
     * @return void
     */
    public function testItCanGetAValue(): void
    {
        $this->contactMethod->setValue('support@pay.nl');

        verify($this->contactMethod->getValue())->string();
        verify($this->contactMethod->getValue())->notEmpty();
        verify($this->contactMethod->getValue())->equals('support@pay.nl');
    }

    /**
     * @return void
     */
    public function testItCanSetADescription(): void
    {
        expect($this->contactMethod->setDescription('Support desk'))->isInstanceOf(ContactMethod::class);
    }

    /**
     * @depends testItCanSetADescription
     *
     * @return void
     */
    public function testItCanGetADescription(): void
    {
        $this->contactMethod->setDescription('Support desk');

        verify($this->contactMethod->getDescription())->string();
        verify($this->contactMethod->getDescription())->notEmpty();
        verify($this->contactMethod->getDescription())->equals('Support desk');
    }
}
