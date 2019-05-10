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
     * @throws Exceptions\BadRequestException
     * @throws Exceptions\NotFoundException
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
     * @throws Exceptions\BadRequestException
     * @throws Exceptions\NotFoundException
     */
    public function post($transaction): Model\Transaction
    {
        $transaction = ($transaction instanceof Model\Transaction) ? $transaction->asArray() : $transaction;

        $response = $this->client->post('transactions', ['json' => $transaction]);

        $result = new Result($response);

        return Model\Transaction::fromArray($result->getData());
    }
}