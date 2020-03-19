<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use Codeception\TestAsset\DummyArrayCollection;
use Codeception\TestAsset\DummyJsonSerializable;
use Codeception\TestAsset\DummyWithoutJsonSerializeImplementation;
use PayNL\Sdk\Common\JsonSerializeTrait;
use PayNL\Sdk\Exception\LogicException;
use ReflectionException;
use UnitTester;

/**
 * Class JsonSerializeTraitTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class JsonSerializeTraitTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

    /** @var JsonSerializeTrait */
    private $mockedTrait;

    /**
     * @throws ReflectionException
     */
    protected function _before()
    {
        $this->mockedTrait = $this->getMockForTrait(JsonSerializeTrait::class);
    }

    /**
     * @return void
     */
    public function testItCanJsonSerialize(): void
    {
        $dummy = new DummyJsonSerializable();
        $this->tester->assertObjectHasMethod('jsonSerialize', $dummy);
        $result = $dummy->jsonSerialize();
        verify($result)->array();
        verify($result['foo'])->equals('bar');
    }

    /**
     * @depends testItCanJsonSerialize
     * @return void
     */
    public function testItCanJsonSerializeWithEmptyProperties(): void
    {
        $dummy = new DummyJsonSerializable();
        $dummy->foo = '';
        $result = $dummy->jsonSerialize();
        verify($result)->array();
        verify($result)->isEmpty();
    }

    /**
     * @depends testItCanJsonSerialize
     * @return void
     */
    public function testIsCanJsonSerializeWithFilteringNestedAndEmpty(): void
    {
        $dummy = new DummyJsonSerializable();
        $dummy->foo = new DummyJsonSerializable();
        $dummy->foo->foo = '';
        $result = $dummy->jsonSerialize();
        verify($result)->array();
        verify($result)->isEmpty();
    }

    /**
     * @depends testItCanJsonSerialize
     * @return void
     */
    public function testItCanJsonSerializeArrayCollection(): void
    {
        $dummy = new DummyArrayCollection();
        verify($dummy->jsonSerialize())->array();
    }

    /**
     * @return void
     */
    public function testItCannotJsonSerialize(): void
    {
        $dummy = new DummyWithoutJsonSerializeImplementation();
        $this->expectException(LogicException::class);
        $dummy->jsonSerialize();
    }
}
