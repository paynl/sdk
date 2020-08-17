<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Validator\Qr;

use CodeCeption\Test\Unit as UnitTest;
use PayNL\Sdk\Validator\Qr\Decode;
use PayNL\Sdk\Validator\RequiredMembers;
use UnitTester;

/**
 * Class DecodeTest
 *
 * @package Tests\Unit\PayNL\Sdk\Validator
 */
class DecodeTest extends UnitTest
{
    /** @var Decode */
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
        $this->validator = new Decode();
    }

    /**
     * @return void
     */
    public function testItExtendsRequiredMembersValidator(): void
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
        verify($requiredMembers)->count(2);
        verify($requiredMembers)->hasKey('uuid');
        verify($requiredMembers)->hasKey('secret');
    }
}