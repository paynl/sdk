<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk;

use Codeception\Test\Unit as UnitTest;
use GuzzleHttp\Client;
use PayNL\Sdk\{
    Api,
    AuthAdapter\AdapterInterface,
    AuthAdapter\Basic,
    Exception\InvalidArgumentException,
    Request\AbstractRequest
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
        $adapterMock = $this->make(Basic::class, [
            'username' => 'harry',
            'password' => 'deSchrikVanElkeCowboy',
        ]);

        $this->api = new Api($adapterMock);
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
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
     * @return void
     */
    public function testItThrowsAnExceptionWhenConstructorGetInvalidArguments(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Api([]);
    }

    /**
     * @depends testItCanConstructWithAnAdapter
     * @depends testItCanConstructWithUsernameAndPassword
     *
     * @return void
     */
    public function testItCanInitiateAHttpClient(): void
    {
        $this->tester->invokeMethod($this->api, 'initClient');
        verify($this->api->getClient())->isInstanceOf(Client::class);
    }

    /**
     * @depends testItCanConstructWithAnAdapter
     * @depends testItCanConstructWithUsernameAndPassword
     *
     * @return void
     */
    public function testItCanHandleACall(): void
    {
        $mockRequest = new class() extends AbstractRequest
        {
            public function getUri(): string
            {
                return 'currencies/EUR';
            }

            public function getMethod(): string
            {
                return AbstractRequest::METHOD_GET;
            }
        };
        $mockRequest->setFormat(AbstractRequest::FORMAT_XML);

        $mockHeaders = [
            'Accept'          => 'application/json',
            'Authorization'   => '',
            'Content-Type'    => 'application/json',
            'X-Custom-Header' => 'Own value'
        ];

        $this->api->setDebug(true)
            ->handleCall($mockRequest, $mockHeaders)
        ;
    }
}
