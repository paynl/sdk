<?php

declare(strict_types=1);

namespace Tests\PayNL\Sdk\unit\Common;

use Codeception\Test\Unit as UnitTest;
use Codeception\TestAsset\DummyFormatAware;
use PayNL\Sdk\{Common\FormatAwareInterface,
    Common\FormatAwareTrait,
    Exception\InvalidArgumentException,
    Exception\LogicException};
use UnitTester,
    ReflectionException;

/**
 * Class FormatAwareTraitTest
 *
 * @package Tests\PayNL\Sdk\unit\Common
 */
class FormatAwareTraitTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @var DummyFormatAware
     */
    protected $dummyFormatAware;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->dummyFormatAware = new DummyFormatAware();
    }

    /**
     * @return void
     */
    public function testItCanCheckInterface(): void
    {
        $this->tester->assertObjectHasMethod('checkInterfaceImplementation', $this->dummyFormatAware);
        $this->tester->assertObjectMethodIsProtected('checkInterfaceImplementation', $this->dummyFormatAware);
    }

    /**
     * @depends testItCanCheckInterface
     *
     * @return void
     */
    public function testCheckInterfaceThrowsException(): void
    {
        $cls = new class() {
            use FormatAwareTrait;
        };

        $this->expectException(LogicException::class);
        $this->tester->invokeMethod($cls, 'checkInterfaceImplementation');
    }

    /**
     * @return void
     */
    public function testItCanSetFormat(): void
    {
        $this->tester->assertObjectHasMethod('setFormat', $this->dummyFormatAware);
        $this->tester->assertObjectMethodIsPublic('setFormat', $this->dummyFormatAware);

        $result = $this->dummyFormatAware->setFormat(FormatAwareInterface::FORMAT_XML);
        verify($result)->isInstanceOf(DummyFormatAware::class);
        verify($result)->same($this->dummyFormatAware);
    }

    /**
     * @depends testItCanSetFormat
     *
     * @return void
     */
    public function testSetFormatThrowsExceptionOnWrongFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->dummyFormatAware->setFormat('foo');
    }

    /**
     * @depends testItCanSetFormat
     *
     * @return void
     */
    public function testItCanGetFormat(): void
    {
        $this->tester->assertObjectHasMethod('getFormat', $this->dummyFormatAware);
        $this->tester->assertObjectMethodIsPublic('getFormat', $this->dummyFormatAware);

        $format = $this->dummyFormatAware->getFormat();
        verify($format)->string();
        verify($format)->equals(FormatAwareInterface::FORMAT_OBJECTS);

        $this->dummyFormatAware->setFormat(FormatAwareInterface::FORMAT_JSON);

        $format = $this->dummyFormatAware->getFormat();
        verify($format)->string();
        verify($format)->equals(FormatAwareInterface::FORMAT_JSON);
    }

    /**
     * @return void
     */
    public function testItCanCheckFormat(): void
    {
        $this->tester->assertObjectHasMethod('isFormat', $this->dummyFormatAware);
        $this->tester->assertObjectMethodIsPublic('isFormat', $this->dummyFormatAware);

        verify($this->dummyFormatAware->isFormat(FormatAwareInterface::FORMAT_JSON))->false();
        verify($this->dummyFormatAware->isFormat(FormatAwareInterface::FORMAT_OBJECTS))->true();
    }
}
