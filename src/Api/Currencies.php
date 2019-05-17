<?php


namespace Paynl\SDK\Api;


use Paynl\SDK\Exception\BadRequestException;
use Paynl\SDK\Exception\NotFoundException;
use Paynl\SDK\Model\Currency;
use Paynl\SDK\Result\Result;

class Currencies extends Api
{
    /**
     * Get a single currency
     *
     * @param string $currencyId
     * @return Currency
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function get(string $currencyId): Currency
    {
        $response = $this->client->get("currencies/" . $currencyId);
        $result = new Result($response);
        return Currency::fromArray($result->getData());
    }

    /**
     * Get all supported currencies
     *
     * @return Currency[]
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function getAll(): array
    {
        $response = $this->client->get("currencies");

        $result = new Result($response);
        return array_map(function ($value) {
            return is_array($value) ? Currency::fromArray($value) : $value;
        }, $result->getData()['currencies']);
    }
}