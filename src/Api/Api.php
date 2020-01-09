<?php

declare(strict_types=1);

namespace PayNL\Sdk\Api;

use PayNL\GuzzleHttp\Client as GuzzleClient;
use PayNL\Sdk\AuthAdapter\AdapterInterface as AuthAdapterInterface;
use PayNL\Sdk\Common\DebugAwareInterface;
use PayNL\Sdk\Common\DebugAwareTrait;
use PayNL\Sdk\Common\OptionsAwareInterface;
use PayNL\Sdk\Common\OptionsAwareTrait;
use PayNL\Sdk\Response\Response;
use PayNL\Sdk\Request\{
    AbstractRequest,
    RequestInterface
};

/**
 * Class Api
 *
 * @package PayNL\Sdk
 */
class Api implements OptionsAwareInterface, DebugAwareInterface
{
    use DebugAwareTrait, OptionsAwareTrait;

    /**
     * @var GuzzleClient
     */
    protected $client;

    /**
     * @var AuthAdapterInterface
     */
    protected $authAdapter;

    /**
     * Api constructor.
     *
     * @param AuthAdapterInterface $authenticationAdapter
     * @param GuzzleClient $client
     * @param array $options
     */
    public function __construct(AuthAdapterInterface $authenticationAdapter, GuzzleClient $client, array $options = [])
    {
        $this->setAuthAdapter($authenticationAdapter)
            ->setClient($client)
            ->setOptions($options)
        ;
    }

    protected function setClient(GuzzleClient $client): self
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return GuzzleClient
     */
    public function getClient(): GuzzleClient
    {
        return $this->client;
    }

    /**
     * @return AuthAdapterInterface
     */
    public function getAuthAdapter(): AuthAdapterInterface
    {
        return $this->authAdapter;
    }

    /**
     * @param AuthAdapterInterface $adapter
     *
     * @return Api
     */
    protected function setAuthAdapter(AuthAdapterInterface $adapter): self
    {
        $this->authAdapter = $adapter;
        return $this;
    }

    /**
     * @param RequestInterface $request
     * param array $headers Additional request headers (Accept, Authorization and Content-Type are already set)
     * @param Response $response
     *
     * @return Response
     */
    public function doHandle(RequestInterface $request, Response $response): Response
    {
        $format = $request->getFormat();
        if (true === $this->isDebug()) {
            $this->dumpDebugInfo('Requested format: ' . $format);
        }

        $client = $this->getClient();

        $acceptHeader = 'application/json';
        if (RequestInterface::FORMAT_XML === $format) {
            $acceptHeader = 'application/xml';
        }

        $request->applyClient($client);
        if ($request instanceof AbstractRequest) {
            $request->setHeader(RequestInterface::HEADER_ACCEPT, $acceptHeader)
                ->setHeader(RequestInterface::HEADER_AUTHORIZATION, $this->getAuthAdapter()->getHeaderString()) // TODO move these to service??
            ;
        }

        $request->execute($response);

        return $response;
    }
}
