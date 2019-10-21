<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\DebugTrait;
use ReflectionException;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

/**
 * Class DebugTraitTest
 *
 * @package Tests\Unit\PayNL\Sdk
 */
class DebugTraitTest extends UnitTest
{
    use VarDumperTestTrait;

    /**
     * @var DebugTrait
     */
    protected $mockedTrait;

    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function _before(): void
    {
        /** @var DebugTrait $mockedTrait */
        $this->mockedTrait = $this->getMockForTrait(DebugTrait::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAndRetrieveDebug(): void
    {
        $this->assertFalse($this->mockedTrait->isDebug());

        $this->mockedTrait->setDebug(true);

        $this->assertTrue($this->mockedTrait->isDebug());
    }

    /**
     * @return void
     */
    public function testItCanDebugAndPrintInfo(): void
    {
        $this->mockedTrait->dumpDebugInfo('test', 'test2');
        $this->expectOutputString('<pre>string(4) "test"' . PHP_EOL . 'string(5) "test2"' . PHP_EOL . '</pre>' . PHP_EOL);
    }
}
