<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Request;


use Codeception\Lib\ManagerTestTrait;
use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Request\RequestInterface;
use PayNL\Sdk\Service\AbstractPluginManager;
use PayNL\Sdk\Request\Manager;
use PayNL\GuzzleHttp\Client;
use PayNL\Sdk\Response\Response;
use Exception;

/**
 * Class ManagerTest
 * @package Tests\Unit\PayNL\Sdk\Request
 */
class ManagerTest extends UnitTest
{
    use ManagerTestTrait {
        testItIsAManager as traitTestItIsAManager;
    }

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->manager = new Manager();
    }

    /**
     * @inheritDoc
     */
    public function testItIsAManager(): void
    {
        $this->traitTestItIsAManager();
        verify($this->manager)->isInstanceOf(AbstractPluginManager::class);
        $this->assertObjectHasAttribute('instanceOf', $this->manager);
        verify($this->manager)->isInstanceOf(Manager::class);
    }

    /**
     * @depends testItIsAManager
     * @return void
     */
    public function testItCanInjectValidatorManager(): void
    {
        $container = $this->tester->getServiceManager();
        $requestMock = $this->tester->grabMockService('requestManager')->get('Request', ['uri' => 'foo/bar']);
        try {
            $this->manager->injectValidatorManager($container, $requestMock);
        } catch (Exception $e) {
            $this->fail();
        }
        verify(true)->true();
    }

    /**
     * @return void
     */
    public function testItDoesNotInjectValidatorManager(): void
    {
        $container = $this->tester->getServiceManager();
        $requestMock = new class() implements RequestInterface {
            public function getUri(): string
            {
                return 'http://foo.bar';
            }

            public function getMethod(): string
            {
                return RequestInterface::METHOD_GET;
            }

            public function getFormat(): string
            {
                return RequestInterface::FORMAT_JSON;
            }

            public function setFormat(string $format)
            {
            }

            public function isFormat(string $format): bool
            {
            }

            public function applyClient(Client $client)
            {
            }

            public function execute(Response $response): void
            {
            }
        };

        try {
            $this->manager->injectValidatorManager($container, $requestMock);
        } catch (Exception $e) {
            $this->fail();
        }
        verify(true)->true();
    }
}
