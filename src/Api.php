<?php

declare(strict_types=1);

namespace PayNL\Sdk;

use GuzzleHttp\Client;
use PayNL\Sdk\AuthAdapter\{
    AdapterInterface,
    Basic
};
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Request\{
    AbstractRequest,
    RequestInterface
};

/**
 * Class Api
 *
 * @package PayNL\Sdk
 */
class Api
{
    use DebugTrait;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var AdapterInterface
     */
    protected $authAdapter;

    /**
     * Api constructor.
     *
     * @param mixed $adapterOrUsername
     * @param string|null $password
     *
     * @throws InvalidArgumentException when given $adapterOrUsername is not a string nor an AdapterInterface object
     */
    public function __construct($adapterOrUsername, string $password = null)
    {
        if (true === is_string($adapterOrUsername)) {
            $adapterOrUsername = new Basic($adapterOrUsername, (string)$password);
        } elseif (!($adapterOrUsername instanceof AdapterInterface)) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s expect argument given to be %s or a string, %s given',
                    __METHOD__,
                    AdapterInterface::class,
                    true === is_object($adapterOrUsername) ? get_class($adapterOrUsername) : gettype($adapterOrUsername)
                )
            );
        }

        $this->setAuthAdapter($adapterOrUsername);
        $this->initClient();
    }

    /**
     * @return void
     */
    protected function initClient(): void
    {
        $config = [
            'base_uri' => Config::getInstance()->getApiUrl(),
        ];

        $this->client = new Client($config);
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @return AdapterInterface
     */
    public function getAuthAdapter(): AdapterInterface
    {
        return $this->authAdapter;
    }

    /**
     * @param AdapterInterface $adapter
     *
     * @return void
     */
    protected function setAuthAdapter(AdapterInterface $adapter): void
    {
        $this->authAdapter = $adapter;
    }

    /**
     * @param AbstractRequest $request
     * @param array $headers Additional request headers (Accept, Authorization and Content-Type are already set)
     *
     * @return Response
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function handleCall(AbstractRequest $request, array $headers = []): Response
    {
        $format = $request->getFormat();
        if (true === $this->isDebug()) {
            $request->setDebug($this->isDebug());
            $this->dumpDebugInfo('Requested format: ' . $format);
        }

        // unset the headers which are set from the request
        unset(
            $headers[RequestInterface::HEADER_ACCEPT],
            $headers[RequestInterface::HEADER_AUTHORIZATION],
            $headers[RequestInterface::HEADER_CONTENT_TYPE]
        );

        $client = $this->getClient();

        // initiate "default" response
        $response = (new Response())
            ->setStatusCode(500)
        ;

        $acceptHeader = 'application/json';
        if (RequestInterface::FORMAT_XML === $format) {
            $acceptHeader = 'application/xml';
        }

        $request->applyClient($client)
            ->addHeader(RequestInterface::HEADER_ACCEPT, $acceptHeader)
            ->addHeader(RequestInterface::HEADER_AUTHORIZATION, $this->getAuthAdapter()->getHeaderString())
        ;

        if (0 < count($headers)) {
            foreach ($headers as $name => $value) {
                $request->addHeader($name, $value);
            }
        }

        $request->execute($response);

        return $response;
    }
}
