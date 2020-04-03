<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Util;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Exception\LogicException;
use PayNL\Sdk\Util\Misc;
use Codeception\TestAsset\SampleConfigProvider;

/**
 * Class MiscTest
 * @package Tests\Unit\PayNL\Sdk\Util
 */
class MiscTest extends UnitTest
{
    /** @var Misc */
    protected $misc;

    /** @var int */
    private $originalFilePermissions;

    /**
     * @return string
     */
    private function getExistingReadableFilename(): string
    {
        return __DIR__ . '/../../_support/TestAsset/SampleConfigProvider.php';
    }

    /**
     * @return string
     */
    private function getExistingReadableFilenameClass(): string
    {
        return '\\' . SampleConfigProvider::class;
    }

    /**
     * @return string
     */
    private function getExistingUnreadableFilename(): string
    {
        return __DIR__ . '/../../_support/TestAsset/UnreadableExistingFile.php';
    }

    /**
     * @return string
     */
    private function getNonExistingFilename(): string
    {
        return __DIR__ . '/../../_support/TestAsset/NonExistingSampleConfigProvider.php';
    }

    /**
     * @return string
     */
    private function getInvalidClassFilename(): string
    {
        return __DIR__ . '/../../_support/TestAsset/FailingConfigProvider.php';
    }

    private function getEmptyFilename(): string
    {
        return __DIR__ . '/../../_support/TestAsset/EmptyFile.php';
    }

    private function getBraceSkippingFilename(): string
    {
        return __DIR__ . '/../../_support/TestAsset/BraceSkippingFile.php';
    }

    protected function _before()
    {
        $this->misc = new Misc();
    }

    /**
     * @return void
     */
    public function testItHandlesNonExistingClassNameByFile(): void
    {
        verify(file_exists($this->getNonExistingFilename()))->false();
        $this->expectException(InvalidArgumentException::class);
        $this->misc::getClassNameByFile($this->getNonExistingFilename());
    }

    /**
     * @return void
     */
    public function testItHandlesExistingUnreadableClassNameByFile(): void
    {
        verify(file_exists($this->getExistingUnreadableFilename()))->true();
        $this->originalFilePermissions = fileperms($this->getExistingUnreadableFilename());
        @chmod($this->getExistingUnreadableFilename(), 0);
        verify(is_readable($this->getExistingUnreadableFilename()))->false();
        $this->expectException(InvalidArgumentException::class);
        $this->misc::getClassNameByFile($this->getExistingUnreadableFilename());
        @chmod($this->getExistingUnreadableFilename(), $this->originalFilePermissions);
    }

    public function testItHandlesBreakingAfterEndOfFile(): void
    {
        $this->expectException(LogicException::class);
        $this->misc::getClassNameByFile($this->getEmptyFilename());
    }

    public function testItHandlesSkippingForBraces(): void
    {
        $this->expectException(LogicException::class);
        $this->misc::getClassNameByFile($this->getBraceSkippingFilename());
    }

    /**
     * @return void
     */
    public function testItHandlesInvalidClassNameByFile(): void
    {
        verify(file_exists($this->getInvalidClassFilename()))->true();
        $this->expectException(LogicException::class);
        $this->misc::getClassNameByFile($this->getInvalidClassFilename());
    }

    /**
     * @return void
     */
    public function testItHandlesValidClassNameByFile(): void
    {
        verify(file_exists($this->getExistingReadableFilename()))->true();
        verify(is_readable($this->getExistingReadableFilename()))->true();
        $data = $this->misc::getClassNameByFile($this->getExistingReadableFilename());
        verify($data)->string();
        verify($data)->equals($this->getExistingReadableFilenameClass());
    }

    /**
     * @return void
     */
    public function testItCanDetermineClassNameForAFullyQualifiedName(): void
    {
        // PSR-4
        $classNameWithNamespace = 'Foo\\Bar\\Baz';
        $className = $this->misc::getClassNameByFQN($classNameWithNamespace);
        verify($className)->string();
        verify($className)->equals('Baz');

        // PSR-0
        $classWithoutANamespace = 'Foo_Bar_Baz';
        $className = $this->misc::getClassNameByFQN($classWithoutANamespace);
        verify($className)->string();
        verify($className)->equals('Foo_Bar_Baz');

        // No PSR
        $class = 'Foo';
        $className = $this->misc::getClassNameByFQN($class);
        verify($className)->string();
        verify($className)->equals('Foo');
    }
}
