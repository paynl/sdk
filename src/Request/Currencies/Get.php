<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Currencies;

use PayNL\Sdk\{
    Exception\MissingParamException,
    Request\AbstractRequest,
    Transformer\TransformerInterface,
    Transformer\Currency as CurrencyTransformer
};

/**
 * Class Currencies
 *
 * @package PayNL\Sdk\Request\Currencies
 */
class Get extends AbstractRequest
{
    /**
     * @var string
     */
    protected $abbreviation;

    public function init(): void
    {
        $currencyId = (string)$this->getParam('currencyId');
        if (null === $currencyId) {
            throw new MissingParamException('Missing param!');
        }

        $this->setAbbreviation($currencyId);
    }

    /**
     * @return string
     */
    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    /**
     * @param string $abbreviation
     *
     * @return Get
     */
    public function setAbbreviation(string $abbreviation): self
    {
        $this->abbreviation = $abbreviation;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        $abbreviation = $this->getAbbreviation();
        return 'currencies/' . $abbreviation;
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_GET;
    }
}
