<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class Receipt
 *
 * @package PayNL\Sdk\Model
 */
class Receipt implements
    ModelInterface,
    Member\LinksAwareInterface,
    Member\PaymentMethodAwareInterface
{
    use Member\LinksAwareTrait;
    use Member\PaymentMethodAwareTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $approvalId;

    /**
     * @var Card
     */
    protected $card;

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
     * @return Receipt
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getSignature(): string
    {
        return (string)$this->signature;
    }

    /**
     * @param string $signature
     *
     * @return Receipt
     */
    public function setSignature(string $signature): self
    {
        $this->signature = $signature;
        return $this;
    }

    /**
     * @return string
     */
    public function getApprovalId(): string
    {
        return (string)$this->approvalId;
    }

    /**
     * @param string $approvalId
     *
     * @return Receipt
     */
    public function setApprovalId(string $approvalId): self
    {
        $this->approvalId = $approvalId;
        return $this;
    }

    /**
     * @return Card
     */
    public function getCard(): Card
    {
        if (null === $this->card) {
            $this->setCard(new Card());
        }
        return $this->card;
    }

    /**
     * @param Card $card
     *
     * @return Receipt
     */
    public function setCard(Card $card): self
    {
        $this->card = $card;
        return $this;
    }
}
