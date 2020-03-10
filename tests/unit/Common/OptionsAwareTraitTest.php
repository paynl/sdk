<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Common;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Common\OptionsAwareInterface;
use PayNL\Sdk\Common\OptionsAwareTrait;
use UnitTester;

class OptionsAwareTraitTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var OptionsAwareTrait
     */
    protected $mockedTrait;

    /**
     * @return void
     */
    public function _before(): void
    {
        /** @var OptionsAwareTrait mockedTrait */
        $this->mockedTrait = new class() implements OptionsAwareInterface {
            use OptionsAwareTrait;

            public function __construct()
            {
                $this->options = [
                    'foo' => 'bar',
                    'baz' => 'qux',
                ];
            }
        };
    }

    /**
     * @return void
     */
    public function testItCanGetOptions(): void
    {
        $this->tester->assertObjectHasMethod('getOptions', $this->mockedTrait);
        $options = $this->mockedTrait->getOptions();
        verify($options)->array();
        verify($options)->count(2);
        verify($options)->hasKey('foo');
        verify($options['foo'])->string();
        verify($options['foo'])->equals('bar');
        verify($options)->hasKey('baz');
        verify($options['baz'])->string();
        verify($options['baz'])->equals('qux');
    }

    /**
     * @return void
     */
    public function testItCanGetAnOption(): void
    {
        $this->tester->assertObjectHasMethod('getOption', $this->mockedTrait);
        $value = $this->mockedTrait->getOption('foo');
        verify($value)->string();
        verify($value)->equals('bar');
    }

    /**
     * @return void
     */
    public function testItCanCheckAnOptionExists(): void
    {
        $this->tester->assertObjectHasMethod('hasOption', $this->mockedTrait);
        verify($this->mockedTrait->hasOption('foo'))->true();
    }

    /**
     * @depends testItCanGetOptions
     * @depends testItCanCheckAnOptionExists
     * @depends testItCanGetAnOption
     *
     * @return void
     */
    public function testItCanAddAnOption(): void
    {
        $this->tester->assertObjectHasMethod('addOption', $this->mockedTrait);
        $this->mockedTrait->addOption('quux', 'corge');
        verify($this->mockedTrait->getOptions())->count(3);
        verify($this->mockedTrait->hasOption('quux'));
        $value = $this->mockedTrait->getOption('quux');
        verify($value)->string();
        verify($value)->equals('corge');
    }

    /**
     * @depends testItCanGetOptions
     *
     * @return void
     */
    public function testItCanClearOptions(): void
    {
        $this->tester->assertObjectHasMethod('clear', $this->mockedTrait);
        $this->tester->assertObjectMethodIsProtected('clear', $this->mockedTrait);

        $this->tester->invokeMethod($this->mockedTrait, 'clear');

        $options = $this->mockedTrait->getOptions();
        verify($options)->array();
        verify($options)->isEmpty();
    }

    /**
     * @depends testItCanClearOptions
     * @depends testItCanAddAnOption
     * @depends testItCanGetOptions
     *
     * @return void
     */
    public function testItCanSetOptions(): void
    {
        $this->tester->assertObjectHasMethod('setOptions', $this->mockedTrait);
        $this->mockedTrait->setOptions([
           'grault' => 'garply',
           'waldo' => 'fred',
        ]);

        $options = $this->mockedTrait->getOptions();
        verify($options)->array();
        verify($options)->count(2);
        verify($options)->hasntKey('foo');
        verify($options)->hasntKey('baz');
        verify($options)->hasKey('grault');
        verify($options['grault'])->string();
        verify($options['grault'])->equals('garply');
        verify($options)->hasKey('waldo');
        verify($options['waldo'])->string();
        verify($options['waldo'])->equals('fred');
    }
}
