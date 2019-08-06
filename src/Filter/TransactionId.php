<?php
declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Class TransactionId
 *
 * @package PayNL\Sdk\Filter
 */
class TransactionId implements FilterInterface
{
    protected $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'transactionId';
    }

    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
