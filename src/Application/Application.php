<?php

declare(strict_types=1);

namespace PayNL\Sdk\Application;

use PayNL\Sdk\{Api\Service as ApiService,
    Common\DebugAwareInterface,
    Common\DebugAwareTrait,
    Config\Config,
    Exception\InvalidArgumentException,
    Hydrator\AbstractHydrator,
    Model\ModelInterface,
    Response\Response,
    Request\AbstractRequest,
    Service\Manager as ServiceManager,
    Service\ManagerConfig as ServiceManagerConfig};

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
     * @param array|Config $configuration
     *
     * @return Application
     */
    public static function init($configuration = []): self
    {
        if (true === ($configuration instanceof Config)) {
            $configuration = $configuration->toArray();
        } elseif (false === is_array($configuration)) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s expects given configuration to be an array or an instance of ' .
                    '%s, %s given',
                    __METHOD__,
                    Config::class,
                    is_object($configuration) ? get_class($configuration) : gettype($configuration)
                )
            );
        }

        $smConfig = new ServiceManagerConfig($configuration['service_manager'] ?? []);

        $serviceManager = new ServiceManager();
        $smConfig->configureServiceManager($serviceManager);
        $serviceManager->setService('ApplicationConfig', new Config($configuration));

        // load components
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

    public function setRequest($request, array $params = null, array $filters = null, $body = null): self
    {
        if (null !== $body) {
            if (true === is_array($body)) {
                $modelType = current(array_keys($body));
                /** @var ModelInterface $model */
                $model = $this->getServiceManager()->get('modelManager')->build($modelType);
                /** @var AbstractHydrator $hydrator */
                $hydrator = $this->getServiceManager()->get('hydratorManager')->build('Entity');
                $body = $hydrator->hydrate($body[$modelType], $model);
            } elseif (false === is_string($body) && false === ($body instanceof ModelInterface)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Given body should be a string, an array or an instance of %s, %s given',
                        ModelInterface::class,
                        is_object($body) ? get_class($body) : gettype($body)
                    )
                );
            }
        }

        if (true === is_string($request)) {
            $request = $this->serviceManager->get('requestManager')
                ->build($request, [
                    'params'  => $params ?: [],
                    'filters' => $filters ?: [],
                    'body'    => $body,
                ])
            ;
        } elseif (false === ($request instanceof AbstractRequest)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Given request should correspond to a request class name or alias, or should be an ' .
                    'instance of %s, %s given',
                    AbstractRequest::class,
                    is_object($request) ? get_class($request) : gettype($request)
                )
            );
        }

        $this->request = $request;
        return $this;
    }

    public function run(): Response
    {
//        dump($this->getServiceManager());die;
        $this->apiService->setRequest($this->request)
            ->setResponse($this->response)
            ->handle();

        return $this->response;
    }
}
