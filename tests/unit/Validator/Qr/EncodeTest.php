<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Validator\Qr;

use CodeCeption\Test\Unit as UnitTest;
use Mockery\MockInterface;
use PayNL\Sdk\Validator\Qr\Encode;
use PayNL\Sdk\Validator\RequiredMembers;
use UnitTester;

/**
 * Class EncodeTest
 *
 * @package Tests\Unit\PayNL\Sdk\Validator
 */
class EncodeTest extends UnitTest
{
    /** @var Encode */
    protected $validator;


    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @returns void
     */
    protected function _before(): void
    {
        $this->validator = new Encode();
    }


    /**
     * @return void
     */
    public function testItExtendsRequiredMembers(): void
    {
        verify($this->validator)->isInstanceOf(RequiredMembers::class);
    }


    /**
     * @return void
     */
    public function testItCanGetRequiredMembers(): void
    {
        $requiredMembers = $this->tester->invokeMethod($this->validator, 'getRequiredMembers', ['']);
        verify($requiredMembers)->array();
        verify($requiredMembers)->count(1);
        verify($requiredMembers)->hasKey('secret');
    }
}