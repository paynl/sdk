<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Util;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Util\Text;

/**
 * Class TextTest
 *
 * @package Tests\PayNL\Sdk\unit\Util
 */
class TextTest extends UnitTest
{
    /**
     * @var Text
     */
    protected $text;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->text = new Text();
    }

    /**
     * @dataProvider _addressCases
     *
     * @param string $address
     * @param array $expectedResult
     *
     * @return void
     */
    public function testItCanSplitAddress(string $address, array $expectedResult): void
    {
        verify($this->text->splitAddress($address))->equals($expectedResult);
    }

    /**
     * @return array
     */
    public function _addressCases(): array
    {
        return [
            ['Jan Campertlaan 10', ['street' => 'Jan Campertlaan', 'number' => '10' ]],
            ['SomeLane 14b',       ['street' => 'SomeLane',        'number' => '14b']],
            ['124 West Avenue',    ['street' => 'West Avenue',     'number' => '124']],
        ];
    }
}
