<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Config;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Config\Config;
use UnitTester,
    Countable,
    Iterator,
    ArrayAccess
;

/**
 * Class ConfigTest
 *
 * @package Tests\Unit\PayNL\Sdk
 */
class ConfigTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->config = new Config([
            'foo' => 'bar',
            'baz' => [
                'qux',
                'quux',
                'corge',
            ],
        ]);
    }

    /**
     * @return void
     */
    public function testItCanConstruct(): void
    {
        verify(new Config())->isInstanceOf(Config::class);
    }

    public function testItIsCountable(): void
    {
        verify($this->config)->isInstanceOf(Countable::class);
    }

    public function testItIsIterable(): void
    {
        verify($this->config)->isInstanceOf(Iterator::class);
    }

    public function testItCanBeAccessedAsArray(): void
    {
        verify($this->config)->isInstanceOf(ArrayAccess::class);
    }

    /**
     * @return void
     */
    public function testItCanClone(): void
    {
        $clone = clone $this->config;
        verify($clone)->equals($this->config);
        verify($clone)->notSame($this->config);
    }

    public function testItCanGetAnEntry(): void
    {
        $this->tester->assertObjectHasMethod('get', $this->config);
        $value = $this->config->get('foo');
        verify($value)->string();
        verify($value)->equals('bar');

        $value = $this->config->get('baz');
        verify($value)->object();
        verify($value)->isInstanceOf(Config::class);
        verify($value)->notEmpty();
    }

    /**
     * @depends testItCanGetAnEntry
     *
     * @return void
     */
    public function testItCanMagicallyGetAnEntry(): void
    {
        $this->tester->assertObjectHasMethod('__get', $this->config);
        $value = $this->config->foo;
        verify($value)->string();
        verify($value)->equals('bar');

        $value = $this->config->baz;
        verify($value)->object();
        verify($value)->isInstanceOf(Config::class);
        verify($value)->notEmpty();
    }

    /**
     * @depends testItCanGetAnEntry
     *
     * @return void
     */
    public function testItCanSetAnEntry(): void
    {
        $this->tester->assertObjectHasMethod('set', $this->config);
        $this->config->set('plugh', 'xyzzy');

        $value = $this->config->get('plugh');
        verify($value)->string();
        verify($value)->equals('xyzzy');

        $this->config->set('thud', [
            'foo',
            'bar' => 'baz'
        ]);

        $value = $this->config->get('thud');
        verify($value)->object();
        verify($value)->isInstanceOf(Config::class);
        verify($value)->notEmpty();
        verify($value)->hasKey('bar');
    }

    /**
     * @depends testItCanSetAnEntry
     * @depends testItCanGetAnEntry
     *
     * @return void
     */
    public function testItCanMagicallySetAnEntry(): void
    {
        $this->tester->assertObjectHasMethod('__set', $this->config);
        $this->config->plugh = 'xyzzy';

        $value = $this->config->get('plugh');
        verify($value)->string();
        verify($value)->equals('xyzzy');

        $this->config->thud = [
            'foo',
            'bar' => 'baz'
        ];

        $value = $this->config->get('thud');
        verify($value)->object();
        verify($value)->isInstanceOf(Config::class);
        verify($value)->notEmpty();
        verify($value)->hasKey('bar');
    }

    /**
     * @return void
     */
    public function testItCanCheckAnEntryExists(): void
    {
        $this->tester->assertObjectHasMethod('has', $this->config);

        $result = $this->config->has('foo');
        verify($result)->bool();
        verify($result)->true();
        verify($this->config->has('non_existing_key'))->false();
    }

    /**
     * @depends testItCanCheckAnEntryExists
     *
     * @return void
     */
    public function testItCanMagicallyCheckAnEntryExists(): void
    {
        $this->tester->assertObjectHasMethod('__isset', $this->config);

        $result = isset($this->config->foo);
        verify($result)->bool();
        verify($result)->true();
        verify(isset($this->config->non_existing_key))->false();
        verify(empty($this->config))->false();
    }

    /**
     * @depends testItCanCheckAnEntryExists
     *
     * @return void
     */
    public function testItCanRemoveAnEntry(): void
    {
        $this->tester->assertObjectHasMethod('remove', $this->config);

        $clone = clone $this->config;
        $this->config->remove('foo');

        verify($this->config->has('foo'))->false();
        verify($clone)->notEquals($this->config);

        $clone = clone $this->config;
        $this->config->remove('non_existing_key');
        verify($clone)->equals($this->config);
    }

    /**
     * @depends testItCanRemoveAnEntry
     *
     * @return void
     */
    public function testItCanMagicallyRemoveAnEntry(): void
    {
        $this->tester->assertObjectHasMethod('__unset', $this->config);

        $clone = clone $this->config;
        unset($this->config->foo);

        verify($this->config->has('foo'))->false();
        verify($clone)->notEquals($this->config);

        $clone = clone $this->config;
        unset($this->config->non_existing_key);
        verify($clone)->equals($this->config);
    }

    public function testItCanBeConvertedToAnArray(): void
    {
        $this->tester->assertObjectHasMethod('toArray', $this->config);

        $output = $this->config->toArray();
        verify($output)->array();
        verify($output)->hasKey('foo');
        verify($output['foo'])->string();
        verify($output['foo'])->equals('bar');
        verify($output)->hasKey('baz');
        verify($output['baz'])->array();
        verify($output['baz'])->count(3);
        verify($output['baz'])->contains('qux');
        verify($output['baz'])->contains('quux');
        verify($output['baz'])->contains('corge');
    }

    public function testItCanGetTheCurrentEntry(): void
    {
        $this->tester->assertObjectHasMethod('current', $this->config);
        $output = $this->config->current();
        verify($output)->string();
        verify($output)->equals('bar');
    }

    /**
     * @depends testItCanGetTheCurrentEntry
     *
     * @return void
     */
    public function testItCanSetThePointerToTheNextEntry(): void
    {
        $this->tester->assertObjectHasMethod('next', $this->config);
        $this->config->next();
        $output = $this->config->current();
        verify($output)->object();
    }

    /**
     * @depends testItCanSetThePointerToTheNextEntry
     *
     * @return void
     */
    public function testItCanGetTheCurrentKey(): void
    {
        $this->tester->assertObjectHasMethod('key', $this->config);

        $key = $this->config->key();
        verify($key)->string();
        verify($key)->equals('foo');

        $this->config->next();

        $key = $this->config->key();

        verify($key)->string();
        verify($key)->equals('baz');
    }

    /**
     * @depends testItCanGetTheCurrentKey
     * @depends testItCanSetThePointerToTheNextEntry
     *
     * @return void
     */
    public function testItCanCheckAnEntryIsValid(): void
    {
        $this->tester->assertObjectHasMethod('valid', $this->config);

        $result = $this->config->valid();
        verify($result)->bool();
        verify($result)->true();

        $this->config->next();
        $this->config->next();

        $result = $this->config->valid();
        verify($result)->bool();
        verify($result)->false();
    }

    /**
     * @depends testItCanGetTheCurrentEntry
     * @depends testItCanSetThePointerToTheNextEntry
     *
     * @return void
     */
    public function testItCanRewind(): void
    {
        $this->tester->assertObjectHasMethod('rewind', $this->config);

        $result = $this->config->current();
        verify($result)->equals('bar');

        $this->config->next();
        $result = $this->config->current();
        verify($result)->isInstanceOf(Config::class);

        $this->config->rewind();

        $result = $this->config->current();
        verify($result)->equals('bar');
    }

    /**
     * @depends testItCanCheckAnEntryExists
     *
     * @return void
     */
    public function testItCanCheckAnOffsetExists(): void
    {
        $this->tester->assertObjectHasMethod('offsetExists', $this->config);

        $result = $this->config->offsetExists('foo');
        verify($result)->bool();
        verify($result)->true();

        $result = $this->config->offsetExists('non_existing_key');
        verify($result)->bool();
        verify($result)->false();
    }

    /**
     * @depends testItCanGetAnEntry
     *
     * @return void
     */
    public function testItCanGetAnEntryByOffset(): void
    {
        $this->tester->assertObjectHasMethod('offsetGet', $this->config);

        $value = $this->config->offsetGet('foo');
        verify($value)->string();
        verify($value)->equals('bar');
    }

    /**
     * @depends testItCanSetAnEntry
     * @depends testItCanCheckAnOffsetExists
     * @depends testItCanGetAnEntryByOffset
     *
     * @return void
     */
    public function testItCanSetAnEntryByOffsetAndValue(): void
    {
        $this->tester->assertObjectHasMethod('offsetSet', $this->config);

        $result = $this->config->offsetExists('waldo');
        verify($result)->bool();
        verify($result)->false();

        $this->config->offsetSet('waldo', 'fred');
        $result = $this->config->offsetExists('waldo');
        verify($result)->bool();
        verify($result)->true();

        $value = $this->config->offsetGet('waldo');
        verify($value)->string();
        verify($value)->equals('fred');
    }

    /**
     * @depends testItCanRemoveAnEntry
     * @depends testItCanCheckAnOffsetExists
     *
     * @return void
     */
    public function testItCanUnsetByOffset(): void
    {
        $this->tester->assertObjectHasMethod('offsetUnset', $this->config);

        $this->config->offsetUnset('foo');

        $result = $this->config->offsetExists('foo');
        verify($result)->false();
    }

    /**
     * @return void
     */
    public function testItCanBeCounted(): void
    {
        $this->tester->assertObjectHasMethod('count', $this->config);

        $count = $this->config->count();
        verify($count)->int();
        verify($count)->equals(2);
    }

    /**
     * @depends testItCanGetAnEntry
     * @depends testItCanSetAnEntry
     * @depends testItCanCheckAnEntryExists
     *
     * @return void
     */
    public function testItCanMergeWithAnotherConfigInstance(): void
    {
        $this->tester->assertObjectHasMethod('merge', $this->config);

        $newConfig = new Config([
            'foo' => 'thud',
            'baz' => [
                'grault',
                'garply'
            ],
            'waldo' => 'fred'
        ]);

        $this->config->merge($newConfig);

        verify($this->config->has('foo'));
        $value = $this->config->get('foo');
        verify($value)->string();
        verify($value)->equals('thud');

        $value = $this->config->get('baz');
        verify($value)->isInstanceOf(Config::class);
        verify($value)->count(3);
        verify($value)->contains('corge');
        verify($value)->contains('grault');
        verify($value)->contains('garply');

        verify($this->config->has('waldo'));
        $value = $this->config->get('waldo');
        verify($value)->string();
        verify($value)->equals('fred');
    }
}
