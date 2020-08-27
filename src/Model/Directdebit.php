<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class Directdebit
 *
 * @package PayNL\Sdk\Model
 */
class Directdebit implements
    ModelInterface,
    Member\AmountAwareInterface,
    Member\BankAccountAwareInterface,
    Member\StatusAwareInterface
{
    use Member\AmountAwareTrait;
    use Member\BankAccountAwareTrait;
    use Member\StatusAwareTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $paymentSessionId;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var Status
     */
    protected $declined;

    /**
     * @return string
     */
    public function getId(): string
    {
        return (string)$this->id;
    }

    /**
     * @param string $id
     *
     * @return Directdebit
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentSessionId(): string
    {
        return (string)$this->paymentSessionId;
    }

    /**
     * @param string $paymentSessionId
     *
     * @return Directdebit
     */
    public function setPaymentSessionId(string $paymentSessionId): self
    {
        $this->paymentSessionId = $paymentSessionId;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return (string)$this->description;
    }

    /**
     * @param string $description
     *
     * @return Directdebit
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Status
     */
    public function getDeclined(): Status
    {
        if (null === $this->declined) {
            $this->setDeclined(new Status());
        }
        return $this->declined;
    }

    /**
     * @param Status $declined
     *
     * @return Directdebit
     */
    public function setDeclined(Status $declined): self
    {
        $this->declined = $declined;
        return $this;
    }
}
