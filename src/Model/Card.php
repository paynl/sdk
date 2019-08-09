<?php
declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class Card
 *
 * @package PayNL\Sdk\Model
 */
class Card implements ModelInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Card
     */
    public function setId(string $id): Card
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Card
     */
    public function setName(string $name): Card
    {
        $this->name = $name;
        return $this;
    }
}
