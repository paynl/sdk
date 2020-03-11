<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Validator;

use CodeCeption\Test\Unit as UnitTest;

use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Exception\RuntimeException;
use PayNL\Sdk\Validator\AbstractValidator;
use PayNL\Sdk\Validator\RequiredMembers;
use PayNL\Sdk\Validator\ValidatorInterface;
use UnitTester;
use Codeception\TestAsset\{Dummy, DummyMissingProperty, DummyWithoutRequiredMembers, DummyHydratorAware};
use Zend\Hydrator\ClassMethods;


class RequiredMembersTest extends UnitTest
{
    /** @var RequiredMembers */
    protected $validator;

    /**
     * @var Dummy
     */
    private $dummy;

    /** @var DummyMissingProperty */
    private $dummyMissingProperty;

    /** @var DummyWithoutRequiredMembers */
    private $dummyWithoutRequiredMembers;

    /** @var DummyHydratorAware */
    private $dummyHydratorAware;

    /**
     * @var UnitTester
     */
    protected $tester;

    private function setHydrator()
    {
        $this->validator->setHydrator(new ClassMethods(false, true));
    }

    protected function _before()
    {
        $this->validator = new RequiredMembers();

        $this->dummy = new Dummy();
        $this->dummyMissingProperty = new DummyMissingProperty();
        $this->dummyWithoutRequiredMembers = new DummyWithoutRequiredMembers();
        $this->dummyHydratorAware = new DummyHydratorAware();
    }

    public function testItIsAValidator(): void
    {
        verify($this->validator)->isInstanceOf(ValidatorInterface::class);
    }

    public function testItExtendsAbstract(): void
    {
        verify($this->validator)->isInstanceOf(AbstractValidator::class);
    }

    public function testGetDataFromObjectWithNullHydratorThrowsException(): void
    {
        $this->expectException(RuntimeException::class);
        $this->tester->invokeMethod($this->validator, 'getDataFromObject', [$this->dummyHydratorAware]);
    }

    public function testGetDataFromObjectWithNonObjectThrowsException(): void
    {
        $this->setHydrator();
        $this->expectException(InvalidArgumentException::class);
        $this->tester->invokeMethod($this->validator, 'getDataFromObject', [1]);
    }

    public function testItCanGetDataFromAGivenObject(): void
    {
        $this->setHydrator();
        $this->dummy->setRequiredMember('some-string');

        $data = $this->tester->invokeMethod($this->validator, 'getDataFromObject', [$this->dummy]);
        verify($data)->array();
        verify($data)->notEmpty();
        verify($data)->hasKey('requiredMember');
        verify($data['requiredMember'])->string();
        verify($data['requiredMember'])->equals('some-string');
    }

    public function testItCanCheckForRequiredMembers(): void
    {
        $this->tester->assertObjectHasMethod('getRequiredMembers', $this->validator);
        $this->tester->assertObjectMethodIsProtected('getRequiredMembers', $this->validator);
        $data = $this->tester->invokeMethod($this->validator, 'getRequiredMembers', [Dummy::class]);
        verify($data)->array();
        verify($data)->notEmpty();
        verify($data)->hasKey('requiredMember');
        verify($data['requiredMember'])->string();
        verify($data['requiredMember'])->equals('string');
    }

    /**
     * @depends testItCanCheckForRequiredMembers
     */
    public function testItCanValidateWithoutRequiredMembers(): void
    {
        $result = $this->validator->isValid($this->dummyWithoutRequiredMembers);
        verify($result)->bool();
        verify($result)->true();
    }

    public function testValidateWithEmptyMembers(): void
    {
        $this->setHydrator();
        $this->dummy->setRequiredMember('');
        $result = $this->validator->isValid($this->dummy);
        verify($result)->bool();
        verify($result)->false();
    }

    public function testValidateWithMissingMembers(): void
    {
        $this->setHydrator();
        $result = $this->validator->isValid($this->dummyMissingProperty);
        verify($result)->bool();
        verify($result)->false();
    }

    public function testItCanTestEmptyOnEmptyOrNullString(): void
    {
        $data = $this->tester->invokeMethod($this->validator, 'isEmpty', ['', '']);
        verify($data)->bool();
        verify($data)->true();

        $data = $this->tester->invokeMethod($this->validator, 'isEmpty', ['', null]);
        verify($data)->bool();
        verify($data)->true();

        $data = $this->tester->invokeMethod($this->validator, 'isEmpty', ['id', 0]);
        verify($data)->bool();
        verify($data)->true();

        $data = $this->tester->invokeMethod($this->validator, 'isEmpty', ['transactionId', 0]);
        verify($data)->bool();
        verify($data)->true();
    }

    public function testItCanTestOnNotEmpty(): void
    {
        $data = $this->tester->invokeMethod($this->validator, 'isEmpty', ['', '12345']);
        verify($data)->bool();
        verify($data)->false();

        $data = $this->tester->invokeMethod($this->validator, 'isEmpty', ['id', '12345']);
        verify($data)->bool();
        verify($data)->false();

        $data = $this->tester->invokeMethod($this->validator, 'isEmpty', ['getId', '12345']);
        verify($data)->bool();
        verify($data)->false();
    }

    /**
     * @depends testItCanTestEmptyOnEmptyOrNullString
     * @depends testItCanTestOnNotEmpty
     */
    public function testValidateCorrectly(): void
    {
        $this->setHydrator();
        $this->dummy->setRequiredMember('12345');
        $result = $this->validator->isValid($this->dummy);
        verify($result)->bool();
        verify($result)->true();
    }
}