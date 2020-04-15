<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Common;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Common\DebugAwareTrait;
use ReflectionException;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

/**
 * Class DebugTraitTest
 *
 * @package Tests\Unit\PayNL\Sdk
 */
class DebugAwareTraitTest extends UnitTest
{
    use VarDumperTestTrait;

    /**
     * @var DebugAwareTrait
     */
    protected $mockedTrait;

    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function _before(): void
    {
        /** @var DebugAwareTrait $mockedTrait */
        $this->mockedTrait = $this->getMockForTrait(DebugAwareTrait::class);
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
        $this->mockedTrait->setDebug(true);
        $this->mockedTrait->dumpDebugInfo('test', 'test2');
        $this->expectOutputString('<pre>string(4) "test"' . PHP_EOL . 'string(5) "test2"' . PHP_EOL . '</pre>' . PHP_EOL);
    }
}
