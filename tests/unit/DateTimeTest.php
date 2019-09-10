<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\DateTime;

/**
 * Class DateTime
 *
 * @package Tests\Unit\PayNL\Sdk
 */
class DateTimeTest extends UnitTest
{
    /**
     * @var DateTime
     */
    protected $dateTimeObject;

    /**
     * @throws \Exception
     *
     * @return void
     */
    public function _before(): void
    {
        $this->dateTimeObject = new DateTime();
    }

    /**
     * @return void
     */
    public function testIsItADateTime(): void
    {
        verify($this->dateTimeObject)->isInstanceOf(DateTime::class);
        verify($this->dateTimeObject)->isInstanceOf(\DateTime::class);
    }

    /**
     * @throws \Exception
     *
     * @return void
     */
    public function testItCanBeCreatedFromString(): void
    {
        verify(DateTime::createFromFormat(DateTime::ATOM, '2018-09-12T14:35:57+02:00'))->isInstanceOf(DateTime::class);

//        $this->expectExceptionCode(\Exception::class);
//        DateTime::createFromFormat(DateTime::ATOM, '')->format(DateTime::ATOM);
    }

    /**
     * @throws \Exception
     *
     * @return void
     */
    public function testItIsJsonSerializable(): void
    {
        $datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2019-08-09 00:00:00');
        verify(json_encode($datetime))->string();
        verify(json_encode($datetime))->equals('"2019-08-09T00:00:00+02:00"');
    }

    /**
     * @return void
     */
    public function testItCanBeConvertedToString(): void
    {
        verify((string)$this->dateTimeObject)->string();
    }
}
