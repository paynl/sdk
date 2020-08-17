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

/**
 * Class RequiredMembersTest
 * @package Tests\Unit\PayNL\Sdk\Validator
 */
class RequiredMembersTest extends UnitTest
{
    /** @var RequiredMembers */
    protected $validator;

    /** @var Dummy */
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

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->validator = new RequiredMembers();
        $this->validator->setHydrator($this->tester->grabService('hydratorManager')->get('Entity'));

        $dummyManager = $this->tester->getServiceManager()->get('dummyManager');

        $this->dummy = $dummyManager->build('dummy');
        $this->dummyMissingProperty = $dummyManager->build('dummyMissingPropery');
        $this->dummyWithoutRequiredMembers = $dummyManager->build('dummyWithoutRequiredMembers');
        $this->dummyHydratorAware = $dummyManager->build('dummyHydratorAware');
    }

    /**
     * @return void
     */
    public function testItIsAValidator(): void
    {
        verify($this->validator)->isInstanceOf(ValidatorInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->validator)->isInstanceOf(AbstractValidator::class);
    }

    /**
     * @return void
     */
    public function testGetDataFromObjectWithNonObjectThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->tester->invokeMethod($this->validator, 'getDataFromObject', [1]);
    }

    /**
     * @return void
     */
    public function testItCanGetDataFromAGivenObject(): void
    {
        $this->dummy->setRequiredMember('some-string');

        $data = $this->tester->invokeMethod($this->validator, 'getDataFromObject', [$this->dummy]);
        verify($data)->array();
        verify($data)->notEmpty();
        verify($data)->hasKey('requiredMember');
        verify($data['requiredMember'])->string();
        verify($data['requiredMember'])->equals('some-string');
    }

    /**
     * @return void
     */
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
     * @return void
     */
    public function testItIsValidWithoutRequiredMembers(): void
    {
        $result = $this->validator->isValid($this->dummyWithoutRequiredMembers);
        verify($result)->bool();
        verify($result)->true();
    }

    /**
     * @depends testItCanCheckForRequiredMembers
     * @return void
     */
    public function testRequiredMembersIsEmptyOnNonExistingClass(): void
    {
        $data = $this->tester->invokeMethod($this->validator, 'getRequiredMembers', ['NonExistingClass']);
        verify($data)->array();
        verify($data)->isEmpty();
    }

    /**
     * @return void
     */
    public function testItIsValidWithEmptyMembers(): void
    {
        $this->dummy->setRequiredMember('');
        $result = $this->validator->isValid($this->dummy);
        verify($result)->bool();
        verify($result)->false();
    }

    /**
     * @return void
     */
    public function testItIsValidWithMissingMembers(): void
    {
        $result = $this->validator->isValid($this->dummyMissingProperty);
        verify($result)->bool();
        verify($result)->false();
    }

    /**
     * @return void
     */
    public function testItCanTestEmptyOnEmptyOrNullString(): void
    {
        foreach(
            [
                ['', ''],
                ['', null],
                ['id', 0],
                ['transactionId', 0]
            ] as $case
        ) {
            $data = $this->tester->invokeMethod($this->validator, 'isEmpty' ,$case);
            verify($data)->bool();
            verify($data)->true();
        }
    }

    /**
     * @return void
     */
    public function testItCanTestOnNotEmpty(): void
    {
        foreach(
            [
                ['', '12345'],
                ['id', '12345'],
                ['getId', '12345']
            ] as $case
        ) {
            $data = $this->tester->invokeMethod($this->validator, 'isEmpty', $case);
            verify($data)->bool();
            verify($data)->false();
        }
    }

    /**
     * @depends testItCanTestEmptyOnEmptyOrNullString
     * @depends testItCanTestOnNotEmpty
     * @return void
     */
    public function testIsValid(): void
    {
        $this->dummy->setRequiredMember('12345');
        $result = $this->validator->isValid($this->dummy);
        verify($result)->bool();
        verify($result)->true();
    }
}