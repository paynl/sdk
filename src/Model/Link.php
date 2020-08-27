<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class Link
 *
 * @package PayNL\Sdk\Model
 */
class Link implements ModelInterface
{
    /**
     * @var string
     */
    protected $rel;

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
    public function getRel(): string
    {
        return (string)$this->rel;
    }

    /**
     * @param string $rel
     *
     * @return Link
     */
    public function setRel(string $rel): self
    {
        $this->rel = $rel;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return (string)$this->type;
    }

    /**
     * @param string $type
     *
     * @return Link
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return (string)$this->url;
    }

    /**
     * @param string $url
     *
     * @return Link
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }
}
