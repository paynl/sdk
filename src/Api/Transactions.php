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
     * @throws Exception\UnprocessableException
     */
    public function get(string $id): Model\Transaction
    {
        $response = $this->client->get("transactions/$id");

        $result = new Result($response);

        return Model\Transaction::fromArray($result->getData());
    }

    /**
     * Approve a transaction that has the status 'verify'
     * @param string $id
     * @return Model\Transaction
     * @throws Exception\BadRequestException
     * @throws Exception\NotFoundException
     * @throws Exception\UnprocessableException
     */
    public function approve(string $id): Model\Transaction
    {
        $response = $this->client->patch("transactions/$id/approve");

        $result = new Result($response);

        return Model\Transaction::fromArray($result->getData());
    }

    /**
     * Decline a transaction that has the status 'verify'
     * @param string $id
     * @return Model\Transaction
     * @throws Exception\BadRequestException
     * @throws Exception\NotFoundException
     * @throws Exception\UnprocessableException
     */
    public function decline(string $id): Model\Transaction
    {
        $response = $this->client->patch("transactions/$id/decline");

        $result = new Result($response);

        return Model\Transaction::fromArray($result->getData());
    }

    /**
     * Capture a transaction that has the status 'authorized'
     * @todo Shouldn't it be possible to partially capture a transaction?
     * @todo It should also be possible to capture products (Klarna)
     *
     * @param string $id
     * @return Model\Transaction
     * @throws Exception\BadRequestException
     * @throws Exception\NotFoundException
     * @throws Exception\UnprocessableException
     */
    public function capture(string $id): Model\Transaction
    {
        $response = $this->client->patch("transactions/$id/capture");

        $result = new Result($response);

        return Model\Transaction::fromArray($result->getData());
    }

    /**
     * Void a transaction that has the status 'authorized'
     *
     * @param string $id
     * @return Model\Transaction
     * @throws Exception\BadRequestException
     * @throws Exception\NotFoundException
     * @throws Exception\UnprocessableException
     */
    public function void(string $id): Model\Transaction
    {
        $response = $this->client->patch("transactions/$id/void");

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
     * @throws Exception\UnprocessableException
     */
    public function post(Model\Transaction $transaction): Model\Transaction
    {
        $arrTransaction = ($transaction instanceof Model\Transaction) ? $transaction->asArray() : $transaction;

        $response = $this->client->post('transactions', ['json' => $arrTransaction]);

        $result = new Result($response);

        return Model\Transaction::fromArray($result->getData());
    }

}