<?php

declare(strict_types=1);

namespace PayNL\Sdk\Api;

use PayNL\Sdk\Request\RequestInterface;
use PayNL\Sdk\Response\Response;
use PayNL\Sdk\Response\ResponseInterface;
use PayNL\Sdk\Service\Manager as ServiceManager;

/**
 * Class Service
 *
 * @package PayNL\Sdk\Api
 */
class Service
{
    /**
     * @var Api
     */
    protected $api;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * Service constructor.
     *
     * @param Api $api
     * @param ServiceManager $serviceManager
     */
    public function __construct(Api $api, ServiceManager $serviceManager)
    {
        $this->api = $api;
        $this->serviceManager = $serviceManager;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @param RequestInterface $request
     *
     * @return Service
     */
    public function setRequest(RequestInterface $request): self
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     *
     * @return Service
     */
    public function setResponse(Response $response): self
    {
        $this->response = $response;
        return $this;
    }

    public function handle(): void
    {
        $request = $this->getRequest();

        // TODO: move header handling to service
        $headers = $request->getHeaders();

        // unset the headers which are set by the api
        unset(
            $headers[RequestInterface::HEADER_ACCEPT],
            $headers[RequestInterface::HEADER_AUTHORIZATION],
            $headers[RequestInterface::HEADER_CONTENT_TYPE]
        );

        /** @var Response $response */
        $response = $this->getResponse();
        if (ResponseInterface::FORMAT_OBJECTS === $response->getFormat()) {
            $mapperManager = $this->serviceManager->get('mapperManager');

            /** @var \PayNL\Sdk\Transformer\Response $transformer */
            $transformer = $this->serviceManager->get('transformerManager')->get('Response');

            $modelName = $mapperManager->get('RequestModelMapper')->getTarget($request);
            if (null !== $modelName) {
                $model = $this->serviceManager->get('modelManager')->build($modelName);
                $hydrator = $this->serviceManager->get('hydratorManager')->build('Entity');

                $transformer->setModel($model)
                    ->setHydrator($hydrator)
                ;
            }

            $response->setTransformer($transformer);
        }

        $this->api->doHandle($request, $response);
    }
}
