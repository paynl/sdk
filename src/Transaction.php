<?php


namespace Paynl\SDK;


use GuzzleHttp\Client;

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
     * @return Result\Transaction
     * @throws Exceptions\NotFoundException
     */
    public function get(string $id): Result\Transaction
    {
        $response = $this->client->get("transactions/$id");

        return new Result\Transaction($response);
    }

    /**
     * Create a new transaction
     *
     * @param array $transaction
     * @return Result\Transaction
     * @throws Exceptions\NotFoundException
     */
    public function post(array $transaction){
        $response = $this->client->post('transactions', ['json' => $transaction]);

        return new Result\Transaction($response);
    }
}