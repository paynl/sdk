<?php


namespace Paynl\SDK\Api;

use Paynl\SDK\Model;
use Paynl\SDK\Exception;
use Paynl\SDK\Result\Result;

class Transactions extends Api
{
    /**
     * Get a single transaction
     *
     * @param string $id
     * @return Model\Transaction
     * @throws Exception\BadRequestException
     * @throws Exception\NotFoundException
     */
    public function get(string $id): Model\Transaction
    {
        $response = $this->client->get("transactions/$id");

        $result = new Result($response);

        return Model\Transaction::fromArray($result->getData());
    }

    /**
     * Create a new transaction
     *
     * @param Model\Transaction $transaction
     * @return Model\Transaction
     * @throws Exception\BadRequestException
     * @throws Exception\NotFoundException
     */
    public function post(Model\Transaction $transaction): Model\Transaction
    {
        $arrTransaction = ($transaction instanceof Model\Transaction) ? $transaction->asArray() : $transaction;

        $response = $this->client->post('transactions', ['json' => $arrTransaction]);

        $result = new Result($response);

        return Model\Transaction::fromArray($result->getData());
    }
}