<?php


namespace Paynl\SDK\Result;


use Paynl\SDK\Exceptions\BadRequestException;
use Paynl\SDK\Exceptions\NotFoundException;
use Psr\Http\Message\ResponseInterface;

class Result
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * Result constructor
     *
     * @param ResponseInterface $response
     * @throws NotFoundException
     * @throws BadRequestException
     */
    public function __construct(ResponseInterface $response)
    {
        if ($response->getStatusCode() == 404) throw new NotFoundException();
        if ($response->getStatusCode() == 400) throw new BadRequestException($response->getBody()->getContents());
        $this->response = $response;
    }

    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    public function getData(): array
    {
        $data = $this->response->getBody()->getContents();

        //todo: remove this when api stops throwing notices
        $data = $this->removeJunk($data);

        return \GuzzleHttp\json_decode($data, true);
    }

    private function removeJunk(string $input)
    {
        $start = strpos($input, '{');
        if ($start > 0) return substr($input, $start);
        return $input;
    }

}