<?php

declare(strict_types=1);

namespace PayNL\Sdk\Application;

use PayNL\Sdk\{
    Api\Service as ApiService,
    Config\Config,
    Exception\InvalidArgumentException,
    Hydrator\AbstractHydrator,
    Model\ModelInterface,
    Response\Response,
    Request\AbstractRequest,
    Service\Manager as ServiceManager,
    Service\ManagerConfig as ServiceManagerConfig
};

/**
 * Class Application
 *
 * @package PayNL\Sdk\Application
 */
class Application
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var ApiService
     */
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
     * @param ServiceManager $serviceManager
     * @param Response $response
     */
    public function __construct(ServiceManager $serviceManager, Response $response)
    {
        $this->serviceManager = $serviceManager;
        $this->response = $response;
    }

    /**
     * Do some extras before running the application
     *
     * @return Application
     */
    public function bootstrap(): self
    {
        $this->apiService = $this->serviceManager->get('ApiService');

        return $this;
    }

    /**
     * Static method for quickly initializing the application
     *
     * @param mixed $configuration
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
     * Get the totally merged configuration of all the declared components and own custom config
     *
     * @return Config
     */
    public function getConfig(): Config
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

    /**
     * @return AbstractRequest
     */
    public function getRequest(): AbstractRequest
    {
        return $this->request;
    }

    /**
     * Give the desired request, which can be a fully configured AbstractRequest object, or a string
     * which may be a FQCN directing to a request class or an alias of that FQCN.
     *
     * Parameters, filters and body can be given only when the given request (name) is a string, otherwise
     * these parameters will be ignored
     *
     * @param mixed $request
     * @param array|null $params
     * @param array|null $filters
     * @param mixed $body
     *
     * @throws InvalidArgumentException when the given request is neither a string nor an instance of AbstractRequest
     *  or it's thrown when the given body is neither an array nor an instance of ModelInterface
     *
     * @return Application
     */
    public function setRequest($request, array $params = null, array $filters = null, $body = null): self
    {
        if (true === is_string($request)) {

            // do we've got a body given? And if yes, is it correct?
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

            // get the request from its manager with the given options
            /** @var AbstractRequest $request */
            $request = $this->serviceManager->get('requestManager')->get($request);

            $request->setParams($params ?? [])
                ->setFilters($filters ?? [])
            ;

            $request->setBody($body);
        } elseif (! ($request instanceof AbstractRequest)) {
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

    /**
     * Spin it up and make the call
     *
     * @return Response
     */
    public function run(): Response
    {
        $this->apiService->setRequest($this->request)
            ->setResponse($this->response)
            ->handle();

        return $this->response;
    }
}
