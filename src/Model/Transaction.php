<?php


namespace Paynl\SDK\Model;

use DateTime;


/**
 * Class Transaction
 * @package Paynl\SDK\Model
 *
 * @property-read string $id
 * @property string $serviceId
 * @property-read Status $status
 * @property string $returnUrl
 * @property Exchange $exchange
 * @property string $reference
 * @property integer $paymentMethodId todo not the same as the getter
 * @property PaymentMethod $paymentMethod;
 * @property integer $paymentMethodSubId todo not the same as the getter
 * @property boolean $testMode todo does not exist in getter
 * @property string $description
 * @property string $orderNumber
 * @property DateTime $invoiceDate
 * @property DateTime $deliveryDate
 * @property Address $address
 * @property Address $billingAddress
 * @property Customer $customer
 * @property-read Merchant $company // todo isn't only a link to the company sufficient?
 * @property Price $price
 * @property Product[] $products
 * @property Statistics $statistics
 * @property-read DateTime $createdAt
 * @property-read DateTime $expiresAt
 * @property-read Link[] $_links
 */
class Transaction extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->exchange = new Exchange();
        $this->paymentMethod = new PaymentMethod();
        $this->address = new Address();
        $this->billingAddress = new Address();
        $this->customer = new Customer();
        $this->customer = new Merchant();
        $this->price = new Price();
        $this->products = [];
        $this->statistics = new Statistics();
    }

    public function __set($name, $value): void
    {
        //convert sub objects
        switch ($name) {
            case 'deliveryDate':
            case 'invoiceDate':
            case 'createdAt':
            case 'expiresAt':
                if (is_string($value)) $value = DateTime::createFromFormat(DateTime::ISO8601, $value);
                break;
        }
        if (is_array($value)) {
            switch ($name) {
                case 'status':
                    $value = Status::fromArray($value);
                    break;
                case 'exchange':
                    $value = Exchange::fromArray($value);
                    break;
                case 'paymentMethod':
                    $value = PaymentMethod::fromArray($value);
                    break;
                case 'billingAddress':
                case 'address':
                    $value = Address::fromArray($value);
                    break;
                case 'customer':
                    $value = Customer::fromArray($value);
                    break;
                case 'company':
                    $value = Merchant::fromArray($value);
                    break;
                case 'price':
                    $value = Price::fromArray($value);
                    break;
                case 'products':
                    $this->_data[$name] = array_map(function ($product) {
                        return is_array($product) ? Product::fromArray($product) : $product;
                    }, $value);
                    return;
                case 'statistics':
                    $value = Statistics::fromArray($value);
                    break;
                case '_links':
                    $this->_data[$name] = array_map(function ($link) {
                        return is_array($link) ? Link::fromArray($link) : $link;
                    }, $value);
                    return;

            }
        }
        parent::__set($name, $value);
    }
}