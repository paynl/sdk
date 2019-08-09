<?php
declare(strict_types=1);

namespace PayNL\Sdk;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\{GuzzleException, RequestException as GuzzleRequestException};
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use PayNL\Sdk\AuthAdapter\{AdapterInterface, Basic};
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Request\{AbstractRequest, RequestInterface};
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

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
     * @param $adapterOrUsername
     * @param string|null $password
     * @param bool $debug
     */
    public function __construct($adapterOrUsername, string $password = null, $debug = false)
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

        $this->setAuthAdapter($adapterOrUsername);
        $this->initClient();
        $this->setDebug($debug);
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
     */
    public function handleCall(AbstractRequest $request, array $headers = []): Response
    {
        $format = $request->getFormat();
        if (true === $this->isDebug()) {
            $request->setDebug($this->getDebug());
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

        try {
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

        } catch (GuzzleException $guzzleException) {
            $errorMessages = '';
            /**
             * @var GuzzleRequestException $guzzleException
             * @var GuzzleResponse $guzzleResponse
             */
            if (true === method_exists($guzzleException, 'getResponse')) { // TODO: refactor this (read stream + convert to messages)
                $guzzleResponse = $guzzleException->getResponse();
                if (null !== $guzzleResponse) {
                    $rawResponseBody = $guzzleResponse->getBody();

                    if (true === $rawResponseBody->isSeekable() && 0 < ($size = $rawResponseBody->getSize())) {
                        $content = $rawResponseBody->read($size);
                        $rawResponseBody->rewind();

                        // TODO: loop through errors and fill $content with correct messages
                        $errorMessages = $content;
//                        $encoder = new JsonEncoder();
//                        if (RequestInterface::FORMAT_XML === $format) {
//                            $encoder = new XmlEncoder();
//                        }
//                        $errors = $encoder->decode($content, $format)['errors'];

                    }
                }
            }

            $response->setStatusCode($guzzleException->getCode())
                ->setRawBody($errorMessages)
                ->setBody($guzzleResponse->getReasonPhrase())
            ;
        } catch (Exception\ExceptionInterface $exception) {
            $response->setStatusCode($exception->getCode()) // TODO add Raw body?
                ->setBody($exception->getMessage())
            ;
        }

        return $response;
    }
}
