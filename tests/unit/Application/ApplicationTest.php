<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Application;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Application\Application;
use PayNL\Sdk\Config\Config;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Request\RequestInterface;
use PayNL\Sdk\Response\ResponseInterface;
use PayNL\Sdk\Service\Manager;
use UnitTester;

/**
 * Class ApplicationTest
 *
 * @package Tests\Unit\PayNL\Sdk\Application
 */
class ApplicationTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var Application
     */
    protected $application;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->application = Application::init($this->tester->getConfig());
        $this->application->setRequest(
            $this->tester->grabMockService('requestManager')
                ->get('Request', ['uri' => 'foo/bar'])
        );
    }

    /**
     * @return void
     */
    public function testItCanConstruct(): void
    {
        new Application(
            $this->tester->getServiceManager(),
            $this->tester->grabMockService('Response')
        );
    }

    /**
     * @return void
     */
    public function testItCanBootStrap(): void
    {
        verify($this->application->bootstrap())->isInstanceOf(Application::class);
    }

    /**
     * @return void
     */
    public function testItCanInitialize(): void
    {
        $application = Application::init($this->tester->getConfig());
        verify($application)->isInstanceOf(Application::class);
    }

    /**
     * @return void
     */
    public function testInitializeThrowsAnException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Application::init(new \stdClass());
    }

    /**
     * @return void
     */
    public function testItCanGetConfiguration(): void
    {
        $config = $this->application->getConfig();
        verify($config)->object();
        verify($config)->isInstanceOf(Config::class);
    }

    /**
     * @return void
     */
    public function testItCanGetServiceManager(): void
    {
        $sm = $this->application->getServiceManager();
        verify($sm)->isInstanceOf(Manager::class);
    }

    /**
     * @return void
     */
    public function testItCanGetRequest(): void
    {
        $request = $this->application->getRequest();
        verify($request)->isInstanceOf(AbstractRequest::class);
    }

    /**
     * @depends testItCanGetRequest
     *
     * @return void
     */
    public function testItCanSetRequestByName(): void
    {
        verify($this->application->setRequest('GetCurrency', ['currencyId' => 'EUR']))
            ->isInstanceOf(Application::class)
        ;

        $request = $this->application->getRequest();
        verify($request)->isInstanceOf(RequestInterface::class);
        verify($request->getBody())->isEmpty();
        verify($request->getUri())->equals('/currencies/EUR');
    }

    /**
     * @depends testItCanGetRequest
     *
     * @return void
     */
    public function testItCanSetRequestObject(): void
    {
        $requestMock = $this->tester->grabMockService('requestManager')->get('Request', ['uri' => 'foo/bar']);
        verify($this->application->setRequest($requestMock))->isInstanceOf(Application::class);
        verify($this->application->getRequest())->same($requestMock);
    }

    /**
     * @return void
     */
    public function testSetRequestThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->application->setRequest(new \stdClass());
    }

    public function testItCanRun(): void
    {
        $this->application->setRequest('GetCurrency', ['currencyId' => 'EUR']);
        $response = $this->application->run();
        verify($response)->isInstanceOf(ResponseInterface::class);
    }
}
