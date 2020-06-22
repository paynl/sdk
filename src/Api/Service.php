<?php

declare(strict_types=1);

namespace PayNL\Sdk\Api;

use PayNL\Sdk\{
    Request\AbstractRequest,
    Request\RequestInterface,
    Response\Response,
    Response\ResponseInterface,
    Service\Manager as ServiceManager,
    Transformer\Response as ResponseTransformer
};

/**
 * Class Service
 *
 * Api Services class which is used to handle the API by "servicing" it
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

    /**
     * Make the call to the endpoint by using the Api instance
     *
     * @return void
     */
    public function handle(): void
    {
        /** @var AbstractRequest $request */
        $request = $this->getRequest();

        $headers = $request->getHeaders();

        // unset the headers which are set by the api
        unset(
            $headers[RequestInterface::HEADER_ACCEPT],
            $headers[RequestInterface::HEADER_AUTHORIZATION],
            $headers[RequestInterface::HEADER_CONTENT_TYPE]
        );

        $response = $this->getResponse();
        // set the transformer for the response if needed!
        if (true === $response->isFormat(ResponseInterface::FORMAT_OBJECTS)) {
            $mapperManager = $this->serviceManager->get('mapperManager');

            /** @var ResponseTransformer $transformer */
            $transformer = $this->serviceManager->get('transformerManager')->get('Response');

            $modelName = $mapperManager->get('RequestModelMapper')->getTarget($request->getOption('name'));
            $transformer->setHydrator($this->serviceManager->get('hydratorManager')->build('Entity'));

            if ('' !== $modelName) {
                $model = $this->serviceManager->get('modelManager')->build($modelName);

                $transformer->setModel($model);
            }
            // ... roll out!
            $response->setTransformer($transformer);
        }

        $this->api->doHandle($request, $response);
    }
}
