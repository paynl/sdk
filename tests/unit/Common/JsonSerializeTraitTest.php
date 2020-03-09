<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Common;

use Codeception\Test\Unit as UnitTest;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @var JsonSerializeTrait
     */
    protected $mockedTrait;

    /**
     * @return void
     */
    public function _before(): void
    {
        /** @var JsonSerializeTrait mockedTrait */
        $this->mockedTrait = new class() implements JsonSerializable {
            use JsonSerializeTrait;

            protected $foo = 'bar';

            protected $baz = 'qux';

            protected $collection;

            public function __construct()
            {
                $this->collection = new ArrayCollection([
                    'quux' => 'corge',
                    'grault' => 'garply',
                    'waldo' => 'fred',
                ]);
            }
        };
    }

    public function testItCanCheckInterface(): void
    {
        $this->tester->assertObjectHasMethod('checkInterfaceImplementation', $this->mockedTrait);
        $this->tester->assertObjectMethodIsProtected('checkInterfaceImplementation', $this->mockedTrait);
    }

    public function testCheckInterfaceThrowsException(): void
    {
        $cls = new class() {
            use JsonSerializeTrait;
        };

        $this->expectException(LogicException::class);
        $this->tester->invokeMethod($cls, 'checkInterfaceImplementation');
    }

    /**
     * @depends testItCanCheckInterface
     *
     * @return void
     */
    public function testItCanJsonSerialize(): void
    {
        $this->tester->assertObjectHasMethod('jsonSerialize', $this->mockedTrait);
        $json = json_encode($this->mockedTrait);

        verify($json)->string();
        verify($json)->notEmpty();
        verify($json)->equals('{"foo":"bar","baz":"qux","collection":{}}');
    }
}
