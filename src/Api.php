<?php
declare(strict_types=1);

namespace PayNL\Sdk;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PayNL\Sdk\AuthAdapter\{AdapterInterface, Basic};
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Request\{AbstractRequest, RequestInterface};

/**
 * Class Api
 *
 * @package PayNL\Sdk
 */
class Api
{
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
     * @param $adapterOrUsername
     * @param string|null $password
     */
    public function __construct($adapterOrUsername, string $password = null)
    {
        if (true === is_string($adapterOrUsername)) {
            $adapterOrUsername = new Basic($adapterOrUsername, $password);
        } elseif (false === ($adapterOrUsername instanceof AdapterInterface)) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s expect argument given to be %s or a string, %s given',
                    __CLASS__,
                    AdapterInterface::class,
                    is_object($adapterOrUsername) ? get_class($adapterOrUsername) : gettype($adapterOrUsername)
                )
            );
        }

        $this->authAdapter = $adapterOrUsername;
        $this->initClient();
    }

    /**
     * @return void
     */
    protected function initClient(): void
    {
        $config = [
            'base_uri' => 'https://rest.idefix.mike.dev.pay.nl/v1/', // TODO set in config value
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
     * @param AbstractRequest $request
     * @param array $headers
     *
     * @return Response
     */
    public function handleCall(AbstractRequest $request, array $headers = []): Response
    {
        $client = $this->getClient();

        try {
            $acceptHeader = 'application/json';
            if (RequestInterface::FORMAT_XML === $request->getFormat()) {
                $acceptHeader = 'application/xml';
            }

            $request->applyClient($client)
                ->addHeader('Accept', $acceptHeader)
                ->addHeader('Authorization', $this->getAuthAdapter()->getHeaderString())
            ;

            if (0 < count($headers)) {
                foreach ($headers as $name => $value) {
                    $request->addHeader($name, $value);
                }
            }

            $response = $request->execute();

        } catch (GuzzleException $clientException) {
            $response = new Response();
            $response->setStatusCode($clientException->getCode())
                ->setBody($clientException->getMessage())
            ;
        }

        return $response;
    }
}
