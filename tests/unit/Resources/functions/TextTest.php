<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Resources\functions;

use Codeception\Test\Unit as UnitTest;

class TextTest extends UnitTest
{
    /**
     * @return void
     */
    public function testFunctionsExist(): void
    {
        verify(function_exists('paynl_split_address'))->true();
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
        verify(paynl_split_address($address))->equals($expectedResult);
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
