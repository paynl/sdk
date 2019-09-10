<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Config;
use UnitTester;

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

    public function _before(): void
    {
        $this->config = Config::getInstance();
    }

    public function testItIsASingleton(): void
    {
        $config = Config::getInstance();
        verify($config)->isInstanceOf(Config::class);

        $this->assertEquals($config, $this->config);

        verify($this->tester->getMethodAccessibility($config, '__construct'))->equals('protected');
        verify($this->tester->getMethodAccessibility($config, '__clone'))->equals('private');
    }

    public function testItCanLoadAConfigurationArray(): void
    {
        $this->config->load([
            Config::KEY_API_URL  => 'https://rest.somehost.topleveldomain',
            Config::KEY_USERNAME => 'piet',
            Config::KEY_PASSWORD => 'blaatschaap',
        ]);

        verify(Config::getInstance()->getApiUrl())->notEmpty();
        verify(Config::getInstance()->getUserName())->notEmpty();
        verify(Config::getInstance()->getPassword())->notEmpty();
    }

    /**
     * @depends testItCanLoadAConfigurationArray
     *
     * @return void
     */
    public function testItCanContainAnApiUrl(): void
    {
        verify(Config::getInstance()->getApiUrl())->equals('https://rest.somehost.topleveldomain');
        verify(
            Config::getInstance()->setApiUrl('http://rest.at.some.other.endpoint')
            ->getApiUrl()
        )->equals('http://rest.at.some.other.endpoint');

        Config::getInstance()->load([
            'wrong_api_key' => 'http://some.bogus.address'
        ]);
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
        verify(
            Config::getInstance()->setUserName('henk')
                ->getUserName()
        )->equals('henk');

        Config::getInstance()->load([
            'wrong_username_key' => 'klaas'
        ]);
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
        verify(
            Config::getInstance()->setPassword('s0M3H4xOrP4ssw0rD')
                ->getPassword()
        )->equals('s0M3H4xOrP4ssw0rD');

        Config::getInstance()->load([
            'wrong_password_key' => '1234'
        ]);
        verify(Config::getInstance()->getPassword())->equals('s0M3H4xOrP4ssw0rD');
    }
}
