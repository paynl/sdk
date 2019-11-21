<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Util;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Util\Vat;

/**
 * Class VatTest
 *
 * @package Tests\Unit\PayNL\Sdk\Util
 */
class VatTest extends UnitTest
{
    /**
     * @var Vat
     */
    protected $vat;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->vat = new Vat();
    }

    /**
     * @return void
     */
    public function testItHasConstants(): void
    {
        verify(defined(get_class($this->vat) . '::CLASS_NONE'))->true();
        verify(Vat::CLASS_NONE)->equals('N');

        verify(defined(get_class($this->vat) . '::CLASS_LOW'))->true();
        verify(Vat::CLASS_LOW)->equals('L');

        verify(defined(get_class($this->vat) . '::CLASS_HIGH'))->true();
        verify(Vat::CLASS_HIGH)->equals('H');
    }

    /**
     * @return void
     */
    public function testItCanGetVatClasses(): void
    {
        verify($this->vat->getVatClasses())->array();
        verify($this->vat->getVatClasses())->notEmpty();
        verify($this->vat->getVatClasses())->count(3);
        verify($this->vat->getVatClasses())->hasKey(Vat::CLASS_NONE);
        verify($this->vat->getVatClasses())->hasKey(Vat::CLASS_LOW);
        verify($this->vat->getVatClasses())->hasKey(Vat::CLASS_HIGH);
        verify($this->vat->getVatClasses()[Vat::CLASS_NONE])->equals(0);
        verify($this->vat->getVatClasses()[Vat::CLASS_LOW])->equals(9);
        verify($this->vat->getVatClasses()[Vat::CLASS_HIGH])->equals(21);
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
        verify($this->vat->calculatePercentage($amountIncludingVat, $vatAmount))->equals($expectedResult);
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
     * @param float $vatPercentage
     * @param string $expectedResult
     *
     * @return void
     */
    public function testItCanDetermineVatClass(float $vatPercentage, string $expectedResult): void
    {
        verify($this->vat->determineVatClass($vatPercentage))->equals($expectedResult);
    }

    /**
     * @return array
     */
    public function _determineClassCases(): array
    {
        return [
            [21.03, 'H'],
            [25.00, 'H'],
            [19.50, 'H'],
            [9.21, 'L'],
            [6.00, 'L'],
            [11.25, 'L'],
            [0.00, 'N'],
            [2.25, 'N'],
        ];
    }
}
