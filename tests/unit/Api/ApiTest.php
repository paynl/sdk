<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Api;

use Codeception\Test\Unit as UnitTest;
use PayNL\GuzzleHttp\{
    Client,
    HandlerStack
};
use PayNL\Sdk\{Api\Api,
    AuthAdapter\AdapterInterface,
    AuthAdapter\Basic,
    Request\Request,
    Request\RequestInterface,
    Response\Response};
use UnitTester, Exception;

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

    /**
     * @throws Exception
     *
     * @return void
     */
    public function _before(): void
    {
        $adapterMock = $this->tester->grabMockService('authAdapterManager')->get('Basic');

        /** @var Client $clientMock */
        $clientMock = $this->make(Client::class, [
            'config' => [
                'base_uri' => 'https://rest-api.idefix.mike.dev.pay.nl',
                'handler'  => HandlerStack::create(),
            ]
        ]);

        $this->api = new Api($adapterMock, $clientMock);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetGuzzleClient(): void
    {
        /** @var Client $clientMock */
        $clientMock = $this->make(Client::class);

        verify($this->tester->invokeMethod($this->api, 'setClient', [$clientMock]))->isInstanceOf(Api::class);
    }

    /**
     * @return void
     */
    public function testItCanGetGuzzleClient(): void
    {
        verify(method_exists($this->api, 'getClient'))->true();
        verify($this->api->getClient())->isInstanceOf(Client::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAuthAdapter(): void
    {
        /** @var AdapterInterface $adapterMock */
        $adapterMock = $this->tester->grabMockService('authAdapterManager')->get('Basic');

        verify($this->tester->invokeMethod($this->api, 'setAuthAdapter', [$adapterMock]))->isInstanceOf(Api::class);
    }

    public function testItCanGetAuthAdapter(): void
    {
        verify(method_exists($this->api, 'getAuthAdapter'))->true();
        verify($this->api->getAuthAdapter())->isInstanceOf(AdapterInterface::class);
    }

//    /**
//     * @return void
//     */
//    public function testItCanConstructWithAnAdapter(): void
//    {
//        $api = $this->api;
//        verify($api)->isInstanceOf(Api::class);
//
//        $adapter = $api->getAuthAdapter();
//        verify($adapter)->isInstanceOf(AdapterInterface::class);
//
//        verify($adapter->getUsername())->equals('harry');
//        verify($adapter->getPassword())->equals('deSchrikVanElkeCowboy');
//
//        verify($adapter->getHeaderString())->equals('Basic ' . base64_encode("{$adapter->getUsername()}:{$adapter->getPassword()}"));
//    }

//    /**
//     * @return void
//     */
//    public function testItCanConstructWithUsernameAndPassword(): void
//    {
//        $api = new Api('LukeSkywalker', 'LookingForMyDad');
//        verify($api)->isInstanceOf(Api::class);
//
//        $adapter = $api->getAuthAdapter();
//        verify($adapter)->isInstanceOf(AdapterInterface::class);
//
//        verify($adapter->getUsername())->equals('LukeSkywalker');
//        verify($adapter->getPassword())->equals('LookingForMyDad');
//
//        verify($adapter->getHeaderString())->equals('Basic ' . base64_encode("{$adapter->getUsername()}:{$adapter->getPassword()}"));
//    }

//    /**
//     * @return void
//     */
//    public function testItThrowsAnExceptionWhenConstructorGetInvalidArguments(): void
//    {
//        $this->expectException(InvalidArgumentException::class);
//        new Api([]);
//    }

//    /**
//     * @depends testItCanConstructWithAnAdapter
//     * @depends testItCanConstructWithUsernameAndPassword
//     *
//     * @return void
//     */
//    public function testItCanInitiateAHttpClient(): void
//    {
//        $this->tester->invokeMethod($this->api, 'initClient');
//        verify($this->api->getClient())->isInstanceOf(Client::class);
//    }

    /**
     * @depends testItCanSetAuthAdapter
     * @depends testItCanSetGuzzleClient
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanDoHandle(): void
    {
        /** @var RequestInterface $mockRequest */
        $mockRequest = $this->makeEmpty(RequestInterface::class);

        /** @var Response $mockResponse */
        $mockResponse = $this->tester->grabMockService('Response');

        $response = $this->api->setDebug(true)
            ->doHandle($mockRequest, $mockResponse)
        ;

        verify($response instanceof Response);
    }
}
