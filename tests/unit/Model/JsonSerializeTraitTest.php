<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\LogicException;
use PayNL\Sdk\Model\JsonSerializeTrait;
use JsonSerializable;


/**
 * Class JsonSerializeTraitTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class JsonSerializeTraitTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItCanJsonSerialize(): void
    {
        /** @var JsonSerializeTrait $mockedTrait */
        $mockedTrait = new class {
            use JsonSerializeTrait;
        };

        $this->expectException(LogicException::class);
        $mockedTrait->jsonSerialize();

        $mockedTrait = new class implements JsonSerializable {
            use JsonSerializeTrait;
        };

        $this->assertIsArray($mockedTrait->jsonSerialize());
    }
}
