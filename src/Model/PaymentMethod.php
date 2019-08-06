<?php
declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class PaymentMethod
 *
 * @package PayNL\Sdk\Model
 */
class PaymentMethod implements ModelInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return PaymentMethod
     */
    public function setId(int $id): PaymentMethod
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
     * @return PaymentMethod
     */
    public function setName(string $name): PaymentMethod
    {
        $this->name = $name;
        return $this;
    }
}
