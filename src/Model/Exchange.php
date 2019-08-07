<?php
declare(strict_types=1);

namespace PayNL\Sdk\Model;

use \JsonSerializable;

/**
 * Class Exchange
 *
 * @package PayNL\Sdk\Model
 */
class Exchange implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $url;

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return Exchange
     */
    public function setMethod(string $method): Exchange
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Exchange
     */
    public function setType(string $type): Exchange
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return Exchange
     */
    public function setUrl(string $url): Exchange
    {
        $this->url = $url;
        return $this;
    }
}
