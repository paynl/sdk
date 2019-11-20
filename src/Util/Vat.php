<?php

declare(strict_types=1);

namespace PayNL\Sdk\Util;

/**
 * Class Tax
 *
 * @package PayNL\Sdk\Util
 */
class Vat
{
    public const CLASS_NONE = 'N';
    public const CLASS_LOW  = 'L';
    public const CLASS_HIGH = 'H';

    protected $vatClasses = [
        self::CLASS_NONE => 0,
        self::CLASS_LOW  => 9,
        self::CLASS_HIGH => 21,
    ];

    /**
     * @param float $amountIncludingVat
     * @param float $vatAmount
     *
     * @return float
     */
    public function calculatePercentage(float $amountIncludingVat, float $vatAmount): float
    {
        if (empty($amountIncludingVat) || empty($vatAmount)) {
            return 0.00;
        }

        if ($amountIncludingVat === $vatAmount) {
            return 100.00;
        }

        return (float) number_format(($vatAmount / ($amountIncludingVat - $vatAmount)) * 100, 2);
    }

    public function determineVatClass(float $vatPercentage): string
    {
        /*
         *  $taxClasses = [
            0  => 'N',
            9  => 'L',
            21 => 'H',
        ];

        $taxRate = paynl_calc_tax_percentage($amountInclTax, $taxAmount);

        return $taxClasses[(static function ($number, array $set) {
            $output = 0;
            $number = (int)$number;
            if (1 < count($set)) {
                $NDat = array();
                foreach ($set as $n) {
                    $NDat[abs($number - $n)] = $n;
                }
                ksort($NDat);
                $NDat = array_values($NDat);
                $output = $NDat[0];
            }
            return $output;
        })($taxRate, array_keys($taxClasses))];
         */

        return (string) array_search((static function (int $inputNumber, array $numberSet) {
            if (1 === count($numberSet)) {
                return 0;
            }

            $numberData = [];
            foreach ($numberSet as $entry) {
                $numberData[abs($inputNumber - $entry)] = $entry;
            }
            ksort($numberData);
            $numberData = array_values($numberData);
            return array_shift($numberData);

        })((int) $vatPercentage, array_values($this->vatClasses)), $this->vatClasses, true);
    }
}
