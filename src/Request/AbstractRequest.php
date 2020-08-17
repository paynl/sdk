<?php /** @noinspection ALL */

declare(strict_types=1);

namespace PayNL\Sdk\Request;

use PayNL\GuzzleHttp\{
    Client,
    Psr7\Request,
    Exception\RequestException,
    Exception\GuzzleException
};
use PayNL\Sdk\{
    Common\DebugAwareInterface,
    Common\DebugAwareTrait,
    Common\FormatAwareTrait,
    Common\OptionsAwareInterface,
    Common\OptionsAwareTrait,
    Exception\EmptyRequiredMemberException,
    Exception\ExceptionInterface,
    Exception\MissingParamException,
    Exception\MissingRequiredMemberException,
    Exception\RuntimeException,
    Model\ModelInterface,
    Response\Response,
    Exception\InvalidArgumentException,
    Filter\FilterInterface,
    Validator\ValidatorManagerAwareInterface,
    Validator\ValidatorManagerAwareTrait
};
use Symfony\Component\Serializer\Encoder\{
    JsonEncoder,
    XmlEncoder
};
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

/**
 * Class AbstractRequest
 *
 * @package PayNL\Sdk\Request
 *
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
abstract class AbstractRequest implements
    RequestInterface,
    DebugAwareInterface,
    OptionsAwareInterface,
    ValidatorManagerAwareInterface
{
    use DebugAwareTrait;
    use OptionsAwareTrait;
    use ValidatorManagerAwareTrait;
    use FormatAwareTrait;

    /*
     * Tag name declaration for XML request string
     */
    public const XML_ROOT_NODE_NAME = 'request';

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var array
     */
    protected $requiredParams = [];

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var null|string
     */
    protected $body;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $params = [];

    /**
     * AbstractRequest constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->setOptions($options);

        if (true === $this->hasOption('format')
            && true === is_string($this->getOption('format'))
        ) {
            $this->setFormat($this->getOption('format'));
        }

        if (true === $this->hasOption('headers')
            && true === is_array($this->getOption('headers'))
        ) {
            $this->setHeaders($this->getOption('headers'));
        }

        $this->init();
    }

    /**
     * Method to execute custom code just after the request construction
     *
     * @return void
     */
    public function init(): void
    {
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param string|int $name
     *
     * @return mixed|null
     */
    public function getParam($name)
    {
        if (false === $this->hasParam($name)) {
            return null;
        }
        return $this->params[$name];
    }

    /**
     * @param string|int $name
     *
     * @return bool
     */
    public function hasParam($name): bool
    {
        return array_key_exists($name, $this->params);
    }

    /**
     * @param array $params
     *
     * @throws MissingParamException
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function setParams(array $params): self
    {
        $this->params = $params;

        foreach ($this->getRequiredParams() as $paramName => $paramDefinition) {
            if (false === $this->hasParam($paramName)) {
                throw new MissingParamException(
                    sprintf(
                        'Missing param "%s"',
                        $paramName
                    )
                );
            }

            if (true === is_string($paramDefinition)
                && '' !== $paramDefinition
                && 1 !== preg_match("/^{$paramDefinition}$/", $this->getParam($paramName))
            ) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Param %s is not valid. It must match "%s"',
                        $paramName,
                        $paramDefinition
                    )
                );
            }
            // set it in the array
            $this->setUri(str_replace("%{$paramName}%", $this->getParam($paramName), $this->getUri()));
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     *
     * @return AbstractRequest
     */
    public function setUri(string $uri): self
    {
        $this->uri = '/' . trim($uri, '/');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return AbstractRequest
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return array
     */
    public function getRequiredParams(): array
    {
        return $this->requiredParams;
    }

    /**
     * @param array $requiredParams
     *
     * @return AbstractRequest
     */
    public function setRequiredParams(array $requiredParams): self
    {
        $this->requiredParams = $requiredParams;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return AbstractRequest
     */
    public function setHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * @param array $headers
     *
     * @return AbstractRequest
     */
    public function setHeaders(array $headers): self
    {
        foreach ($headers as $name => $header) {
            $this->setHeader($name, $header);
        }
        return $this;
    }

    /**
     * @param string $name
     *
     * @return string|null
     */
    public function getHeader(string $name): ?string
    {
        return $this->headers[$name] ?? null;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        if (false === is_string($this->body) && null !== $this->body) {
            /** @var ModelInterface $body */
            $body = $this->body;
            // validate the given body (model) for the required members
            $this->validateBody($body);
            return $this->encodeBody($body);
        }

        return (string)$this->body;
    }

    /**
     * Automatically converts the given body to a string based
     * on the set format
     *
     * @param mixed $body
     *
     * @return AbstractRequest
     */
    public function setBody($body): self
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @inheritDoc
     *
     * @return AbstractRequest
     */
    public function applyClient(Client $client): self
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return Client
     */
    public function getClient(): ?Client
    {
        return $this->client;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @param string $name
     *
     * @return FilterInterface|null
     */
    public function getFilter(string $name): ?FilterInterface
    {
        return $this->filters[$name] ?? null;
    }

    /**
     * @param array $filters
     *
     * @throws InvalidArgumentException
     *
     * @return AbstractRequest
     */
    public function setFilters(array $filters): self
    {
        // reset the filters
        $this->filters = [];

        foreach ($filters as $filter) {
            if (false === $filter instanceof FilterInterface) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Supplied filter is not of type %s',
                        FilterInterface::class
                    )
                );
            }
            $this->addFilter($filter);
        }
        return $this;
    }

    /**
     * @param FilterInterface $filter
     *
     * @return AbstractRequest
     */
    public function addFilter(FilterInterface $filter): self
    {
        $this->filters[$filter->getName()] = $filter;
        return $this;
    }

    /**
     * Automatically adds a Content-Type header
     *
     * @param mixed $body
     *
     * @return string
     */
    private function encodeBody($body): string
    {
        $encoder = new JsonEncoder();
        $contentTypeHeader = 'application/json';
        $context = [
            'json_encode_options' => JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | ($this->isDebug() === true ? JSON_PRETTY_PRINT : 0),
        ];

        if (true === $this->isFormat(static::FORMAT_XML)) {
            $encoder = new XmlEncoder([
                XmlEncoder::ROOT_NODE_NAME => static::XML_ROOT_NODE_NAME,
            ]);
            $contentTypeHeader = 'application/xml';
            $context = [];
        }
        $this->setHeader(static::HEADER_CONTENT_TYPE, $contentTypeHeader);

        return (string)$encoder->encode($body, $this->getFormat(), $context);
    }

    /**
     * @param Response $response
     *
     * @throws RuntimeException when no HTTP client is set
     *
     * @return void
     */
    public function execute(Response $response): void
    {
        $uri = trim($this->getUri(), '/');
        $filters = $this->getFilters();

        $uri = trim($uri . '?' . implode('&', $filters), '?');

        $this->dumpDebugInfo('Request body: ' . $this->getBody());

        try {
            $guzzleClient = $this->getClient();
            if (false === ($guzzleClient instanceof Client)) {
                throw new RuntimeException('No HTTP client found', 500);
            }

            // create a Guzzle PSR 7 Request
            $guzzleRequest = new Request($this->getMethod(), $uri, $this->getHeaders(), $this->getBody());

            $this->dumpDebugInfo('Requested URL: ' . rtrim((string)$guzzleClient->getConfig('base_uri'), '/') . '/' . $guzzleRequest->getUri());
            $this->dumpDebugInfo('Headers:' . PHP_EOL . PHP_EOL . implode(PHP_EOL, array_map(static function ($item, $key) {
                return "{$key}: {$item}";
            }, $this->getHeaders(), array_keys($this->getHeaders()))));

            $guzzleResponse = $guzzleClient->send($guzzleRequest);

            $rawBody = $guzzleResponse->getBody()->getContents();

            $statusCode = $guzzleResponse->getStatusCode();
            $body = $rawBody;
        } catch (RequestException $re) {
            $errorMessages = '';
            $rawBody = $re->getMessage();

            if (true === method_exists($re, 'getResponse') && null !== $re->getResponse()) {
                $guzzleExceptionBody = $re->getResponse()->getBody();
                $size = $guzzleExceptionBody->isSeekable() === true ? (int)$guzzleExceptionBody->getSize() : 0;

                if (0 < $size) {
                    $content = $guzzleExceptionBody->read($size);
                    $guzzleExceptionBody->rewind();

                    $errorMessages = $content;
                }

                $rawBody = trim($re->getResponse()->getReasonPhrase() . ': ' . $errorMessages, ': ');
            }

            $statusCode = $re->getCode();
            $body = '';
            if ('' !== $errorMessages) {
                $body = $this->getErrorsString($response->getFormat(), (int)$statusCode, $errorMessages);
            }
        } catch (GuzzleException | ExceptionInterface $e) {
            $statusCode = $e->getCode() ?? 500;
            $rawBody = 'Error: ' . $e->getMessage() . ' (' . $statusCode . ')';
            $body = $this->getErrorsString($response->getFormat(), (int)$statusCode, $rawBody);
        }

        $response->setStatusCode($statusCode)
            ->setRawBody($rawBody)
            ->setBody($body)
        ;

        $this->dumpDebugInfo('Response: ', $response);
    }

    /**
     * @param string $responseFormat
     * @param int $statusCode
     * @param string $rawBody
     *
     * @return string
     */
    private function getErrorsString(string $responseFormat, int $statusCode, string $rawBody): string
    {
        $encoderClass = JsonEncoder::class;
        if (static::FORMAT_XML === $responseFormat) {
            $encoderClass = XmlEncoder::class;
        }

        $encoder = new $encoderClass();
        try {
            $errors = $encoder->decode($rawBody, $responseFormat);
        } catch (NotEncodableValueException $notEncodableValueException) {
            $statusCode = $notEncodableValueException->getCode();
            $rawBody = $notEncodableValueException->getMessage();
            $errors = [];
        }

        $errors = [
            'errors' => [
                'general' => [
                    'context' => 'unknown',
                    'code'    => $statusCode,
                    'message' => $rawBody,
                ]
            ]
        ];
        // if given raw body already is Json return that
        if (true === array_key_exists('errors', $errors)) {
            // reformat the errors
            $errors['errors'] = $this->flattenErrors($errors['errors']);
        }

        return (string)$encoder->encode($errors, $responseFormat);
    }

    /**
     * @param array $errors
     * @param string $context
     *
     * @return array
     */
    protected function flattenErrors(array $errors, string $context = ''): array
    {
        if (true === array_key_exists('code', $errors) && true === array_key_exists('message', $errors)) {
            $errors['context'] = $context;
            return [$context => $errors];
        }

        $return = [];
        foreach ($errors as $key => $value) {
            $return[$key] = $value;
            if (true === is_array($value)) {
                $return = $this->flattenErrors($value, ltrim($context . ".{$key}", '.'));
            }
        }
        return $return;
    }

    /**
     * Validates the given body, when it contains a ModelInterface object, if it contains all
     *  the required properties
     *
     * @param mixed $body
     *
     * @throws RuntimeException when the body is an object and it's invalid
     *
     * @return void
     */
    protected function validateBody($body): void
    {
        if (true === is_string($body)) {
            return;
        }

        $validator = $this->getValidatorManager()->getValidatorByRequest($this);

        if (true === $validator->isValid($body)) {
            return;
        }

        // create exception stack
        $counter = 0;
        $prev = null;
        foreach ($validator->getMessages() as $type => $message) {
            $exceptionClass = MissingRequiredMemberException::class;
            if (true === in_array($type, [$validator::MSG_EMPTY_MEMBER, $validator::MSG_EMPTY_MEMBERS], true)) {
                $exceptionClass = EmptyRequiredMemberException::class;
            }
            $e = new $exceptionClass($message, 500, ($counter++ !== 0 ? $prev : null));
            $prev = $e;
        }

        throw new RuntimeException(
            sprintf(
                'Object "%s" is not valid',
                __CLASS__
            ),
            500,
            $prev
        );
    }
}
