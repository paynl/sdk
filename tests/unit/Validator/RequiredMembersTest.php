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
use Codeception\TestAsset\{
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

    public function testGetDataFromObjectWithNullHydratorThrowsException(): void
    {
        $this->expectException(RuntimeException::class);
        $this->tester->invokeMethod($this->validator, 'getDataFromObject', [$this->dummyHydratorAware]);
    }

    public function testGetDataFromObjectWithNonObjectThrowsException(): void
    {
        $this->validator->setHydrator(new ClassMethods());
        $this->expectException(InvalidArgumentException::class);
        $this->tester->invokeMethod($this->validator, 'getDataFromObject', [1]);
    }

    public function testItCanGetDataFromAGivenObject(): void
    {
        $this->validator->setHydrator(new ClassMethods());
        $this->dummy->setRequiredMember('some-string');

        $data = $this->tester->invokeMethod($this->validator, 'getDataFromObject', [$this->dummy]);
        verify($data)->array();
        verify($data)->notEmpty();
        verify($data)->hasKey('required_member');
        verify($data['required_member'])->string();
        verify($data['required_member'])->equals('some-string');
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
}