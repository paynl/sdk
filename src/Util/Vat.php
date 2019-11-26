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
    /*
     * Class type constant definitions
     */
    public const CLASS_NONE = 'N';
    public const CLASS_LOW  = 'L';
    public const CLASS_HIGH = 'H';

    /**
     * @var array
     */
    protected $vatClasses = [
        self::CLASS_NONE => 0,
        self::CLASS_LOW  => 9,
        self::CLASS_HIGH => 21,
    ];

    /**
     * @return array
     */
    public function getVatClasses(): array
    {
        return $this->vatClasses;
    }

    /**
     * @param float $amountIncludingVat
     * @param float $vatAmount
     *
     * @return float
     */
    public function calculatePercentage(float $amountIncludingVat, float $vatAmount): float
    {
        if (empty($amountIncludingVat) === true || empty($vatAmount) === true) {
            return 0.00;
        }

        if ($amountIncludingVat === $vatAmount) {
            return 100.00;
        }

        return (float)number_format(($vatAmount / ($amountIncludingVat - $vatAmount)) * 100, 2);
    }

    /**
     * Gives the nearest VAT class based on the given percentage.
     *
     * @param float $vatPercentage
     *
     * @return string
     */
    public function determineVatClass(float $vatPercentage): string
    {
        $vatClasses = $this->getVatClasses();
        return (string)array_search((static function (int $inputNumber, array $numberSet) {
            // determine the nearest
            $numberData = [];
            foreach ($numberSet as $entry) {
                $numberData[abs($inputNumber - $entry)] = $entry;
            }
            ksort($numberData);
            $numberData = array_values($numberData);
            return array_shift($numberData);
        })((int)$vatPercentage, array_values($vatClasses)), $vatClasses, true);
    }
}
