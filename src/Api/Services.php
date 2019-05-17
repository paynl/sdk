<?php


namespace Paynl\SDK\Api;


use Paynl\SDK\Exception\BadRequestException;
use Paynl\SDK\Exception\NotFoundException;
use Paynl\SDK\Model\PaymentMethod;
use Paynl\SDK\Model\Service;
use Paynl\SDK\Result\Result;

class Services extends Api
{
    /**
     * @return Service[]
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function getAll(): array
    {
        $response = $this->client->get('services');

        $result = new Result($response);

        $arrServices = $result->getData();

        return array_map(function ($value) {
            return is_array($value) ? Service::fromArray($value) : $value;
        }, $arrServices['services']);
    }

    public function get(string $serviceId): Service
    {
        $response = $this->client->get('services/' . $serviceId);

        $result = new Result($response);

        return Service::fromArray($result->getData());
    }

    /**
     * @param string $serviceId
     * @return PaymentMethod[]
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function getPaymentMethods(string $serviceId): array
    {
        $response = $this->client->get('services/' . $serviceId.'/paymentmethods');

        $result = new Result($response);
        $arrPaymentMethods = $result->getData();

        return array_map(function ($value) {
            return is_array($value) ? PaymentMethod::fromArray($value) : $value;
        }, $arrPaymentMethods['paymentMethods']);
    }
}