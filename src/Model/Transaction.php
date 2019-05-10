<?php


namespace Paynl\SDK\Model;


/**
 * Class Transaction
 * @package Paynl\SDK\Model
 *
 * @property string $id
 * @property string $serviceId
 * @property Status $status
 * @property string $returnUrl
 * @property Exchange $exchange
 * @property string $reference
 * @property integer $paymentMethodId
 * @property integer $paymentMethodSubId
 * @property boolean $testMode
 * @property string $description
 * @property string $orderNumber
 * @property Address $address
 * @property Address $billingAddress
 * @property Price $price
 * @property Product[] $products
 */
class Transaction extends Model
{
    public function __set($name, $value): void
    {
        //convert sub objects
        if (is_array($value)) {
            switch ($name) {
                case 'status':
                    $value = Status::fromArray($value);
                    break;
                case 'exchange':
                    $value = Exchange::fromArray($value);
                    break;
                case 'address':
                    $value = Address::fromArray($value);
                    break;
                case 'billingAddress':
                    $value = Address::fromArray($value);
                    break;
                case 'price':
                    $value = Price::fromArray($value);
                    break;
                case 'products':
                    $this->_data[$name] = array_map(function ($product) {
                        return is_array($product) ? Product::fromArray($product) : $product;
                    }, $value);
                    return;
                    break;
            }
        }
        parent::__set($name, $value);
    }
}