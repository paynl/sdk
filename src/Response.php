<?php
declare(strict_types=1);

namespace PayNL\Sdk;

use PayNL\Sdk\Exception\InvalidArgumentException;

/**
 * Class Response
 *
 * @package PayNL\Sdk
 */
class Response
{
    public const HTTP_STATUS_CODES = [
        100 => 'Continue',
        101 => 'Switching protocol',
        102 => 'Processing',

        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Multi-Status',
        226 => 'IM Used',

        300 => 'Multiple Choice',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'unused',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',

        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Field Too Large',
        451 => 'Unavailable For Legal Reasons',

        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    ];

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string
     */
    protected $rawBody;

    /**
     * @var mixed
     */
    protected $body;

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     *
     * @return Response
     */
    public function setStatusCode(int $statusCode): Response
    {
        if (false === array_key_exists($statusCode, self::HTTP_STATUS_CODES)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Status code "%s" is unavailable',
                    $statusCode
                )
            );
        }
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getRawBody(): string
    {
        return $this->rawBody;
    }

    /**
     * @param string $rawBody
     *
     * @return Response
     */
    public function setRawBody(string $rawBody): Response
    {
        $this->rawBody = $rawBody;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        if (true === empty($this->body) && true === array_key_exists($this->getStatusCode(), self::HTTP_STATUS_CODES)) {
            $this->setBody(self::HTTP_STATUS_CODES[$this->getStatusCode()]);
        }
        return $this->body;
    }

    /**
     * @param mixed $body
     *
     * @return Response
     */
    public function setBody($body): Response
    {
        $this->body = $body;
        return $this;
    }
}
