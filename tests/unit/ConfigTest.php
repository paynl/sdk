<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Config;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Exception\UnexpectedValueException;
use UnitTester;

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
     * @return void
     */
    public function testItIsASingleton(): void
    {
        $config = Config::getInstance();
        verify($config)->isInstanceOf(Config::class);

        $this->assertEquals($config, Config::getInstance());

        verify($this->tester->getMethodAccessibility(Config::getInstance(), '__construct'))->equals('protected');
        verify($this->tester->getMethodAccessibility(Config::getInstance(), '__clone'))->equals('private');
    }

    /**
     * @return void
     */
    public function testItCanLoadAConfigurationArray(): void
    {
        Config::getInstance()->load([
            Config::KEY_API_URL  => 'https://rest.somehost.topleveldomain',
            Config::KEY_USERNAME => 'piet',
            Config::KEY_PASSWORD => 'blaatschaap',
        ]);

        verify(Config::getInstance()->get(Config::KEY_API_URL))->notEmpty();
        verify(Config::getInstance()->get(Config::KEY_USERNAME))->notEmpty();
        verify(Config::getInstance()->get(Config::KEY_PASSWORD))->notEmpty();
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenApiUrlIsNotSet(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Config::getInstance()->load([
            Config::KEY_USERNAME => 'piet',
            Config::KEY_PASSWORD => 'blaatschaap',
        ]);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenUsernameIsNotSet(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Config::getInstance()->load([
            Config::KEY_API_URL  => 'https://rest.somehost.topleveldomain',
            Config::KEY_PASSWORD => 'blaatschaap',
        ]);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenPasswordIsNotSet(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Config::getInstance()->load([
            Config::KEY_API_URL  => 'https://rest.somehost.topleveldomain',
            Config::KEY_USERNAME => 'piet',
        ]);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenConfigKeyIsNotAString(): void
    {
        $this->expectException(UnexpectedValueException::class);
        Config::getInstance()->load([
            Config::KEY_API_URL  => 'https://rest.somehost.topleveldomain',
            Config::KEY_USERNAME => 'piet',
            Config::KEY_PASSWORD => 'blaatschaap',
            1 => 'value',
        ]);
    }

    /**
     * @depends testItCanLoadAConfigurationArray
     *
     * @return void
     */
    public function testItCanContainAnApiUrl(): void
    {
        verify(Config::getInstance()->getApiUrl())->equals('https://rest.somehost.topleveldomain');
        Config::getInstance()->set(Config::KEY_API_URL, 'http://rest.at.some.other.endpoint');
        verify(Config::getInstance()->getApiUrl())->equals('http://rest.at.some.other.endpoint');

        Config::getInstance()->set('wrong_api_key', 'http://some.bogus.address');
        verify(Config::getInstance()->getApiUrl())->equals('http://rest.at.some.other.endpoint');
    }

    /**
     * @depends testItCanLoadAConfigurationArray
     *
     * @return void
     */
    public function testItCanContainAnUsername(): void
    {
        verify(Config::getInstance()->getUserName())->equals('piet');
        Config::getInstance()->set(Config::KEY_USERNAME, 'henk');
        verify(Config::getInstance()->getUserName())->equals('henk');

        Config::getInstance()->set('wrong_username_key', 'klaas');
        verify(Config::getInstance()->getUserName())->equals('henk');
    }

    /**
     * @depends testItCanLoadAConfigurationArray
     *
     * @return void
     */
    public function testItCanContainAPassword(): void
    {
        verify(Config::getInstance()->getPassword())->equals('blaatschaap');
        Config::getInstance()->set(Config::KEY_PASSWORD, 's0M3H4xOrP4ssw0rD');
        verify(Config::getInstance()->getPassword())->equals('s0M3H4xOrP4ssw0rD');

        Config::getInstance()->set('wrong_password_key', '1234');
        verify(Config::getInstance()->getPassword())->equals('s0M3H4xOrP4ssw0rD');
    }

    public function testItReturnsNullWhenConfigKeyDoesNotExist(): void
    {
        verify(Config::getInstance()->get('test'))->null();
    }
}
