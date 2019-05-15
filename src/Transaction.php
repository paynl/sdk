<?php


namespace Paynl\SDK;


use GuzzleHttp\Client;
use Paynl\SDK\Result\Result;

class Transaction
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }


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