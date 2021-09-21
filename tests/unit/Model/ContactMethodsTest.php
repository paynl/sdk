<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Lib\CollectionTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{
    ContactMethods,
    ContactMethod
};
use TypeError;

/**
 * Class ContactMethodsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ContactMethodsTest extends UnitTest
{
    use ModelTestTrait, CollectionTestTrait {
        testItCanBeAccessedLikeAnArray as traitTestItCanBeAccessedLikeAnArray;
        testItCanGetCollectionName as traitTestItCanGetCollectionName;
    }

    /**
     * @var ContactMethods
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new ContactMethods();
    }

    /**
     * @param string $type
     *
     * @return ContactMethod
     */
    private function getMockContactMethod(string $type): ContactMethod
    {
        /** @var ContactMethod $contactMethod */
        $contactMethod = $this->tester->grabService('modelManager')->build(ContactMethod::class);
        $contactMethod->setType($type);
        return $contactMethod;
    }

    /**
     * @return void
     */
    public function testItCanAddContactMethod(): void
    {
        $this->tester->assertObjectHasMethod('addContactMethod', $this->model);
        $this->tester->assertObjectMethodIsPublic('addContactMethod', $this->model);

        $mockContactMethod = $this->getMockContactMethod('foo');

        $contactMethods = $this->model->addContactMethod($mockContactMethod);
        verify($contactMethods)->object();
        verify($contactMethods)->same($this->model);
        verify($contactMethods)->hasKey($mockContactMethod->getType());
    }

    /**
     * @depends testItCanAddContactMethod
     *
     * @return void
     */
    public function testItCanSetContactMethods(): void
    {
        $this->tester->assertObjectHasMethod('setContactMethods', $this->model);
        $this->tester->assertObjectMethodIsPublic('setContactMethods', $this->model);

        $mockContactMethod = $this->getMockContactMethod('foo');

        $contactMethods = $this->model->setContactMethods([$mockContactMethod]);
        verify($contactMethods)->object();
        verify($contactMethods)->same($this->model);
        verify($contactMethods)->containsOnlyInstancesOf(ContactMethod::class);
        verify($contactMethods)->notEmpty();
        verify($contactMethods)->count(1);

        $contactMethods = $this->model->setContactMethods([
            $this->getMockContactMethod('bar'),
            $this->getMockContactMethod('baz'),
        ]);
        verify($contactMethods)->object();
        verify($contactMethods)->same($this->model);
        verify($contactMethods)->containsOnlyInstancesOf(ContactMethod::class);
        verify($contactMethods)->count(2);
        verify($contactMethods)->notContains($mockContactMethod);
    }

    /**
     * @depends testItCanAddContactMethod
     * @depends testItCanSetContactMethods
     *
     * @return void
     */
    public function testSetContactMethodsThrowsTypeError(): void
    {
        $this->expectException(TypeError::class);
        $this->model->setContactMethods([$this->getMockContactMethod('foo'), []]);
    }

    /**
     * @depends testItCanAddContactMethod
     * @depends testItCanSetContactMethods
     *
     * @return void
     */
    public function testItCanSetEmptyContactMethods(): void
    {
        $contactMethods = $this->model->setContactMethods([]);
        verify($contactMethods)->isInstanceOf(ContactMethods::class);
        verify($contactMethods)->same($this->model);
        verify($contactMethods)->count(0);
    }

    /**
     * @depends testItCanSetContactMethods
     *
     * @return void
     */
    public function testItCanGetContactMethods(): void
    {
        $this->tester->assertObjectHasMethod('getContactMethods', $this->model);
        $this->tester->assertObjectMethodIsPublic('getContactMethods', $this->model);

        $mockContactMethod = $this->getMockContactMethod('foo');

        $this->model->setContactMethods([$mockContactMethod]);
        $contactMethods = $this->model->getContactMethods();
        verify($contactMethods)->array();
        verify($contactMethods)->count(1);
        verify($contactMethods)->hasKey('foo');
        verify($contactMethods)->containsOnlyInstancesOf(ContactMethod::class);
    }

    /**
     * @depends testItCanSetContactMethods
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        $this->traitTestItCanBeAccessedLikeAnArray();

        $this->model->setContactMethods([ $this->getMockContactMethod('foo') ]);

        // offsetExists
        verify(isset($this->model['foo']))->true();
        verify(isset($this->model['bar']))->false();

        // offsetGet
        verify($this->model['foo'])->isInstanceOf(ContactMethod::class);

        // offsetSet
        $this->model['baz'] = $this->getMockContactMethod('baz');
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
        verify($this->model->getCollectionName())->equals('contactMethods');
    }
}
