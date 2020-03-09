<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Validator;

use CodeCeption\Test\Unit as UnitTest;

use PayNL\Sdk\Exception\RuntimeException;
use PayNL\Sdk\Validator\AbstractValidator;
use PayNL\Sdk\Validator\RequiredMembers;
use PayNL\Sdk\Validator\ValidatorInterface;
use UnitTester;
use Codeception\Mock\{
    Dummy,
    DummyWithoutRequiredMembers,
    DummyHydratorAware
};
use Zend\Hydrator\ClassMethods;


class RequiredMembersTest extends UnitTest
{
    /** @var RequiredMembers */
    protected $validator;

    /**
     * @var Dummy
     */
    private $dummy;

    /** @var DummyWithoutRequiredMembers */
    private $dummyWithoutRequiredMembers;

    /** @var DummyHydratorAware */
    private $dummyHydratorAware;

    /**
     * @var UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->validator = new RequiredMembers();

        $hydrator = new ClassMethods();
        $this->validator->setHydrator($hydrator);

        $this->dummy = new Dummy();
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

    public function testGetDataFromObjectTrowsExceptionWithHydratorlessObject(): void
    {
        $this->expectException(RuntimeException::class);
        $data = $this->tester->invokeMethod($this->validator, 'getDataFromObject', [$this->dummyWithoutRequiredMembers]);
    }

    public function testItCanGetDataFromAGivenObject()
    {
        $this->dummy->setRequiredMember('some-string');

        $data = $this->tester->invokeMethod($this->validator, 'getDataFromObject', [$this->dummy]);
        verify($data)->array();
        verify($data)->notEmpty();
        verify($data)->hasKey('requiredMember');
        verify($data['requiredMember'])->equals('some-string');
    }

    public function testItCanCheckForRequiredMembers(): void
    {
        $this->tester->assertObjectHasMethod('getRequiredMembers', $this->validator);
        $this->tester->assertObjectMethodIsProtected('getRequiredMembers', $this->validator);
        $requiredMembers = $this->tester->invokeMethod($this->validator, 'getRequiredMembers', [Dummy::class]);
        verify($requiredMembers)->array();
        verify($requiredMembers)->notEmpty();
        verify($requiredMembers)->hasKey('requiredMember');
        verify($requiredMembers['requiredMember'])->string();
        verify($requiredMembers['requiredMember'])->equals('string');
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

    public function testItCantGetMembersOfNonExistentObjects(): void
    {
        $result = $this->validator->
        verify($this->validator)->
    }
}