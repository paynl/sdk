<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk;

use Codeception\Test\Unit as UnitTest;
use GuzzleHttp\Client;
use PayNL\Sdk\Api;
use PayNL\Sdk\AuthAdapter\AdapterInterface;
use PayNL\Sdk\AuthAdapter\Basic;
use UnitTester;

/**
 * Class ApiTest
 *
 * @package Tests\Unit\PayNL\Sdk
 */
class ApiTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var Api
     */
    protected $api;

    public function _before()
    {
        $adapterMock = $this->make(Basic::class, [
            'username' => 'harry',
            'password' => 'deSchrikVanElkeCowboy',
        ]);

        $this->api = new Api($adapterMock);
    }

    public function testItCanConstructWithAnAdapter(): void
    {
        $api = $this->api;
        verify($api)->isInstanceOf(Api::class);

        $adapter = $api->getAuthAdapter();
        verify($adapter)->isInstanceOf(AdapterInterface::class);

        verify($adapter->getUsername())->equals('harry');
        verify($adapter->getPassword())->equals('deSchrikVanElkeCowboy');

        verify($adapter->getHeaderString())->equals('Basic ' . base64_encode("{$adapter->getUsername()}:{$adapter->getPassword()}"));
    }

    public function testItCanConstructWithUsernameAndPassword(): void
    {
        $api = new Api('LukeSkywalker', 'LookingForMyDad');
        verify($api)->isInstanceOf(Api::class);

        $adapter = $api->getAuthAdapter();
        verify($adapter)->isInstanceOf(AdapterInterface::class);

        verify($adapter->getUsername())->equals('LukeSkywalker');
        verify($adapter->getPassword())->equals('LookingForMyDad');

        verify($adapter->getHeaderString())->equals('Basic ' . base64_encode("{$adapter->getUsername()}:{$adapter->getPassword()}"));
    }

    /**
     * @depends testItCanConstructWithAnAdapter
     *
     * @return void
     */
    public function testItCanInitiateAHttpClient(): void
    {
        $this->tester->invokeMethod($this->api, 'initClient');
        verify($this->api->getClient())->isInstanceOf(Client::class);
    }

    public function testItCanHandleACall(): void
    {
        // TODO: fix this test
    }
}
