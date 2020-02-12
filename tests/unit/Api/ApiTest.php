<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Api;

use Codeception\Test\Unit as UnitTest;
use PayNL\GuzzleHttp\Client;
use PayNL\Sdk\{
    Api\Api,
    AuthAdapter\AdapterInterface,
    AuthAdapter\Basic,
    Request\Request,
    Response\Response
};
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
        /** @var AdapterInterface $adapterMock */
        $adapterMock = $this->make(Basic::class, [
            'username' => 'harry',
            'password' => 'deSchrikVanElkeCowboy',
        ]);

        /** @var Client $clientMock */
        $clientMock = $this->make(Client::class, [
            'config' => [
                'base_uri' => 'https://rest-api.idefix.mike.dev.pay.nl',
                'handler'  => \PayNL\GuzzleHttp\HandlerStack::create(),
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

    public function testItCanSetAuthAdapter(): void
    {
        /** @var AdapterInterface $adapterMock */
        $adapterMock = $this->make(Basic::class, [
            'username' => 'harry',
            'password' => 'deSchrikVanElkeCowboy',
        ]);

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
        $mockRequest = new Request('currencies/EUR', Request::METHOD_GET);/* extends Request
        {
//            public function getUri(): string
//            {
//                return 'currencies/EUR';
//            }
//
//            public function getMethod(): string
//            {
//                return Request::METHOD_GET;
//            }
        };*/
        $mockRequest->setFormat(Request::FORMAT_XML);

//        $mockHeaders = [
//            'Accept'          => 'application/json',
//            'Authorization'   => '',
//            'Content-Type'    => 'application/json',
//            'X-Custom-Header' => 'Own value'
//        ];

        /** @var Response $mockResponse */
        $mockResponse = $this->make(Response::class);

        $response = $this->api->setDebug(true)
            ->doHandle($mockRequest, $mockResponse)
        ;

        verify($response instanceof Response);
    }
}
