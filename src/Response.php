<?php
declare(strict_types=1);

namespace PayNL\Sdk;

/**
 * Class Response
 *
 * @package PayNL\Sdk
 */
class Response
{
    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var mixed
     */
    protected $body;

    /**
     * @return int
     */
    public function getStatusCode()
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
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
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
