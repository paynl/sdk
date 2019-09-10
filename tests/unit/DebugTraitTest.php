<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\DebugTrait;
use ReflectionException;

/**
 * Class DebugTraitTest
 *
 * @package Tests\Unit\PayNL\Sdk
 */
class DebugTraitTest extends UnitTest
{
    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanSetAndRetrieveDebug(): void
    {
        /** @var DebugTrait $mockedTrait */
        $mockedTrait = $this->getMockForTrait(DebugTrait::class);

        $this->assertFalse($mockedTrait->isDebug());

        $mockedTrait->setDebug(true);

        $this->assertTrue($mockedTrait->isDebug());
    }
}
