<?php


namespace Paynl\SDK\Api;


use Paynl\SDK\Model\Terminal;
use Paynl\SDK\Result\Result;

class Terminals extends Api
{
    /**
     * @return Terminal[]
     *
     * @throws \Paynl\SDK\Exception\BadRequestException
     * @throws \Paynl\SDK\Exception\NotFoundException
     */
    public function getAll(): array
    {
        $response = $this->client->get('terminals');

        $result = new Result($response);
        $arrResult = $result->getData();

        return array_map(function($value){
            return is_array($value) ? Terminal::fromArray($value) : $value;
        }, $arrResult['terminals']);
    }
}