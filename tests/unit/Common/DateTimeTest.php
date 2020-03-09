<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Common;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Common\DateTime;
use DateTime as stdDateTime;
use Exception;
use UnitTester;

/**
 * Class DateTime
 *
 * @package Tests\Unit\PayNL\Sdk
 */
class DateTimeTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

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
        verify($this->dateTimeObject)->isInstanceOf(stdDateTime::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanBeCreatedFromString(): void
    {
        verify(DateTime::createFromFormat(DateTime::ATOM, '2018-09-12T14:35:57+02:00'))->isInstanceOf(DateTime::class);
    }

    /**
     * @throws Exception
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

    /**
     * @return void
     */
    public function testItCanInitNow(): void
    {
        $this->tester->assertClassHasMethod('now', DateTime::class);
        $this->tester->assertClassMethodIsStatic('now', DateTime::class);

        $datetime = DateTime::now();
        verify($datetime)->isInstanceOf(DateTime::class);
    }
}
