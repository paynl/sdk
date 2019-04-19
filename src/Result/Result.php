<?php


namespace Paynl\SDK\Result;


use Paynl\SDK\Exceptions\NotFoundException;
use Psr\Http\Message\ResponseInterface;

class Result
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * Result constructor.
     * @param ResponseInterface $response
     * @throws NotFoundException
     */
    public function __construct(ResponseInterface $response)
    {
        if($response->getStatusCode() == 404 ) throw new NotFoundException();
        $this->response = $response;
    }

    public function getStatusCode(){
        return $this->response->getStatusCode();
    }
    public function getData(){
        echo $data = $this->response->getBody()->getContents();
        return \GuzzleHttp\json_decode($data, true);
    }

}