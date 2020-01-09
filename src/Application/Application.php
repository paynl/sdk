<?php

declare(strict_types=1);

namespace PayNL\Sdk\Application;

use PayNL\Sdk\{
    Api\Service as ApiService,
    Common\DebugAwareInterface,
    Common\DebugAwareTrait,
    Response\Response,
    Request\AbstractRequest,
    Service\Manager as ServiceManager,
    Service\ManagerConfig as ServiceManagerConfig
};

class Application implements DebugAwareInterface
{
    use DebugAwareTrait;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /** @var ApiService */
    protected $apiService;

    /**
     * @var AbstractRequest
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * Application constructor.
     *
     * @param $serviceManager
     * @param Response $response
     */
    public function __construct($serviceManager, Response $response)
    {
        $this->serviceManager = $serviceManager;
        $this->response = $response;
    }

    public function bootstrap(): self
    {
        $this->apiService = $this->serviceManager->get('ApiService');

        return $this;
    }

    /**
     * @param array $configuration
     *
     * @return Application
     */
    public static function init(array $configuration = []): self
    {
        $smConfig = new ServiceManagerConfig($configuration);

        $serviceManager = new ServiceManager();
        $smConfig->configureServiceManager($serviceManager);
        $serviceManager->setService('ApplicationConfig', $configuration);

        $serviceManager->get('serviceLoader')->load();

        return $serviceManager->get(static::class)->bootstrap();
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->serviceManager->get('config');
    }

    /**
     * @return ServiceManager
     */
    public function getServiceManager(): ServiceManager
    {
        return $this->serviceManager;
    }

    public function getRequest(): AbstractRequest
    {
        return $this->request;
    }

    public function setRequest($request, ...$params): self
    {
        if (true === is_string($request)) {
            $request = $this->serviceManager->get('requestManager')->get($request, $params);
        } elseif (false === ($request instanceof AbstractRequest)) {
            throw new \Exception(
                'Wrong!'
            );
        }

        $this->request = $request;
        return $this;
    }

    public function run(): Response
    {
        $this->apiService->setRequest($this->request)
            ->setResponse($this->response)
            ->handle();

        return $this->response;
    }
}
