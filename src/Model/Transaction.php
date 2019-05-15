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
 * @property-read Merchant $company
 * @property Price $price
 * @property Product[] $products
 * @property-read Link[] $_links
 * @property-read DateTime $createdAt
 * @property-read DateTime $expiresAt
 */
class Transaction extends Model
{
    protected function getDateFormat(string $field): string
    {
        switch($field){
            case 'deliveryDate':
            case 'invoiceDate':
//                return 'd-m-Y'; todo Documentation does not match actual format
            case 'createdAt':
            case 'expiresAt':
                return DateTime::ISO8601;
        }

        return parent::getDateFormat($field);
    }

    public function __set($name, $value): void
    {
        //convert sub objects
        switch ($name) {
            case 'deliveryDate':
            case 'invoiceDate':
            case 'createdAt':
            case 'expiresAt':
                if (is_string($value)) $value = DateTime::createFromFormat($this->getDateFormat($name), $value);
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