<?php

namespace Paynl\Api\Payment\Model;

class Order extends Model
{
    /**
     * @var string
     */
    private $deliveryDate;

    /**
     * @var string
     */
    private $invoiceDate;

    /**
     * @var array
     */
    private $products;

    /**
     * @return string
     */
    public function getDeliveryDate()
    {
        return $this->deliveryDate;
    }

    /**
     * @param $deliveryDate
     * @return $this
     */
    public function setDeliveryDate($deliveryDate)
    {
        $this->deliveryDate = $deliveryDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceDate()
    {
        return $this->invoiceDate;
    }

    /**
     * @param $invoiceDate
     * @return $this
     */
    public function setInvoiceDate($invoiceDate)
    {
        $this->invoiceDate = $invoiceDate;
        return $this;
    }

    /**
     * @param Product $product
     * @return array
     */
    public function addProduct(Product $product)
    {
        return $this->products[] = $product->toArray();
    }

    /**
     * @return string
     */
    public function getProducts()
    {
        return $this->products;
    }

}