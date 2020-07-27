<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Validator\Qr;

use CodeCeption\Test\Unit as UnitTest;
use Codeception\TestAsset\Dummy;
use Codeception\TestAsset\DummyQr;
use PayNL\Sdk\Validator\AbstractValidator;
use PayNL\Sdk\Validator\Qr\Decode;
use PayNL\Sdk\Validator\ValidatorInterface;
use UnitTester;
use Zend\Hydrator\ClassMethods;

/**
 * Class DecodeTest
 *
 * @package Tests\Unit\PayNL\Sdk\Validator
 */
class DecodeTest extends UnitTest
{
    /** @var Decode */
    protected $validator;

    /** @var DummyQr */
    private $dummy;

    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @returns void
     */
    protected function _before(): void
    {
        $this->validator = new Decode();

        $this->dummy = new DummyQr();
    }

    /**
     * @returns void
     */
    private function setHydrator(): void
    {
        $this->validator->setHydrator(new ClassMethods(false, true));
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
    public function testItCanValidate(): void
    {
        $this->setHydrator();

        $this->tester->assertObjectHasMethod('isValid', $this->validator);
        $this->tester->assertObjectMethodIsPublic('isValid', $this->validator);
        $data = $this->tester->invokeMethod($this->validator, 'isValid', [$this->dummy]);
        $this->assertIsBool($data);
        $this->assertFalse($data);
        $this->assertNotEmpty($this->validator->getMessages());
    }

    /**
     * @return void
     */
    public function testItCanValidateWithEmptyMembers(): void
    {
        $this->setHydrator();

        $this->dummy->setUuid('');
        $this->dummy->setSecret('');
        $data = $this->validator->isValid($this->dummy);
        $this->assertIsBool($data);
        $this->assertFalse($data);
        $this->assertNotEmpty($this->validator->getMessages());
    }

    /**
     * @return void
     */
    public function testItCanValidateWithMissingMembers(): void
    {
        $this->setHydrator();

        $data = $this->validator->isValid(new Dummy());
        $this->assertIsBool($data);
        $this->assertFalse($data);
        $this->assertNotEmpty($this->validator->getMessages());
    }

    /**
     * @returns void
     */
    public function testItCanValidateCorrectly(): void
    {
        $this->setHydrator();

        $this->dummy->setUuid('uuid');
        $this->dummy->setSecret('secret');
        $data = $this->validator->isValid($this->dummy);
        $this->assertIsBool($data);
        $this->assertTrue($data);
        $this->assertEmpty($this->validator->getMessages());
    }
}