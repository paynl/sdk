<?php


namespace Paynl\SDK\Result;


use Paynl\SDK\Exception\BadRequestException;
use Paynl\SDK\Exception\NotFoundException;
use Paynl\SDK\Exception\UnprocessableException;
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
     * @throws UnprocessableException
     */
    public function __construct(ResponseInterface $response)
    {
        if ($response->getStatusCode() == 404) throw new NotFoundException();
        if ($response->getStatusCode() == 400) throw new BadRequestException($response->getBody()->getContents());
        if ($response->getStatusCode() == 422) throw new UnprocessableException($response->getBody()->getContents());

        if($response->getStatusCode() != 200 && $response->getStatusCode() != 201 ) throw new \Exception($response->getStatusCode().' - '.$response->getBody()->getContents(), $response->getStatusCode());
        $this->response = $response;
    }

    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    // TODO: Think about paginated responses

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