<?php


namespace Paynl\SDK\Api;


use GuzzleHttp\Client;

class Api
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

}