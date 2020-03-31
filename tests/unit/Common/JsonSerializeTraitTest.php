<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Common;

use Codeception\Test\Unit as UnitTest;
use Codeception\TestAsset\DummyArrayCollection;
use Codeception\TestAsset\DummyJsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;
use JsonSerializable, UnitTester;
use PayNL\Sdk\Exception\LogicException;

class JsonSerializeTraitTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var DummyJsonSerializable
     */
    private $dummyJsonSerializable;

    /**
     * @var DummyArrayCollection
     */
    protected $dummyArrayCollection;

    /**
     * @return void
     */
    public function _before(): void
    {
        /** @var JsonSerializeTrait mockedTrait */
        $this->dummyJsonSerializable = new DummyJsonSerializable();
        $this->dummyArrayCollection = new DummyArrayCollection();
    }

    /**
     * @return void
     */
    public function testItCanCheckInterface(): void
    {
        $this->tester->assertObjectHasMethod('checkInterfaceImplementation', $this->dummyJsonSerializable);
        $this->tester->assertObjectMethodIsProtected('checkInterfaceImplementation', $this->dummyJsonSerializable);
    }

    /**
     * @return void
     */
    public function testCheckInterfaceThrowsException(): void
    {
        $cls = new class() {
            use JsonSerializeTrait;
        };

        $this->expectException(LogicException::class);
        $this->tester->invokeMethod($cls, 'checkInterfaceImplementation');
    }

    /**
     * depends testItCanCheckInterface
     *
     * @return void
     */
    public function testItCanJsonSerialize(): void
    {
        $this->tester->assertObjectHasMethod('jsonSerialize', $this->dummyJsonSerializable);
        $json = json_encode($this->dummyJsonSerializable);

        verify($json)->string();
        verify($json)->notEmpty();
        verify($json)->equals('{"foo":"bar","baz":"qux","collection":{"foo":"bar"}}');
    }

    /**
     * @return void
     */
    public function testItCanJsonSerializeArrayCollection(): void
    {
        $json = json_encode($this->dummyArrayCollection);
        verify($json)->string();
        verify($json)->notEmpty();
        verify($json)->equals('{"foo":"bar"}');
    }

    /**
     * @return void
     */
    public function testItCanFilterEmptyProperties(): void
    {
        $cls = new class() implements JsonSerializable {
            use JsonSerializeTrait;
            protected $emptyProperty = '';
            protected $emptyCollection;
            public function __construct()
            {
                $this->emptyCollection = new DummyArrayCollection();
            }
        };

        $json = json_encode($cls);
        verify($json)->string();
        verify($json)->notEmpty();
        verify($json)->equals('{"emptyCollection":{"foo":"bar"}}');
    }
}
