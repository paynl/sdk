<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Resources\functions;

use Codeception\Test\Unit as UnitTest;

/**
 * Class VatTest
 *
 * @package Tests\Unit\PayNL\Sdk\Resources\functions
 */
class VatTest extends UnitTest
{
    /**
     * @return void
     */
    public function testFunctionsExist(): void
    {
        verify(function_exists('paynl_calc_vat_percentage'))->true();
        verify(function_exists('paynl_determine_vat_class'))->true();
    }

    /**
     * @dataProvider _percentageCases
     *
     * @param float $amountIncludingVat
     * @param float $vatAmount
     * @param $expectedResult
     *
     * @return void
     */
    public function testCalculatePercentage(float $amountIncludingVat, float $vatAmount, float $expectedResult): void
    {
        verify(paynl_calc_vat_percentage($amountIncludingVat, $vatAmount))->equals($expectedResult);
    }

    /**
     * @return array
     */
    public function _percentageCases(): array
    {
        return [
            [0.00, 12.95, 0.00],
            [12.95, 0.00, 0.00],
            [21.95, 21.95, 100.00],
            [121.00, 21.00, 21.00],
        ];
    }

    /**
     * @dataProvider _determineClassCases
     *
     * @param float $amountIncludingVat
     * @param float $vatAmount
     * @param string $expectedResult
     *
     * @return void
     */
    public function testItCanDetermineVatClass(float $amountIncludingVat, float $vatAmount, string $expectedResult): void
    {
        verify(paynl_determine_vat_class($amountIncludingVat, $vatAmount))->equals($expectedResult);
    }

    /**
     * @return array
     */
    public function _determineClassCases(): array
    {
        return [
            [121.00, 21.00, 'H'],
            [125.00, 25.00, 'H'],
            [119.50, 19.50, 'H'],
            [109.00, 9.00, 'L'],
            [106.00, 6.00, 'L'],
            [111.25, 11.25, 'L'],
            [0.00, 0.00, 'N'],
            [102.25, 2.25, 'N'],
        ];
    }
}
