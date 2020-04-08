<?php

namespace Paynl\Result\Transaction;

use Paynl\Result\Result;

/**
 * Result class for a Details
 *
 * @author PAY. <support@pay.nl>
 */
class Details extends Result
{   

    /**
     * @return array Full array paymentDetails
     */
    public function getPaymentDetails()
    {
        return (isset($this->data['paymentDetails'])) ? $this->data['paymentDetails'] : array();              
    }  

    /**
     * @return string The transactionId
     */
    public function getTransactionId()
    {            
        return (isset($this->data['paymentDetails']['transactionId'])) ? $this->data['paymentDetails']['transactionId'] : '';       
    }   

    /**
     * @return string The orderId
     */
    public function getOrderId()
    {            
        return (isset($this->data['paymentDetails']['orderId'])) ? $this->data['paymentDetails']['orderId'] : '';       
    }   

    /**
     * @return string The orderNumber
     */
    public function getOrderNumber()
    {            
        return (isset($this->data['paymentDetails']['orderNumber'])) ? $this->data['paymentDetails']['orderNumber'] : '';       
    }   

    /**
     * @return string The paymentProfileId
     */
    public function getPaymentProfileId()
    {            
        return (isset($this->data['paymentDetails']['paymentProfileId'])) ? $this->data['paymentDetails']['paymentProfileId'] : '';       
    }   

    /**
     * @return string The paymentProfileName
     */
    public function getPaymentProfileName()
    {            
        return (isset($this->data['paymentDetails']['paymentProfileName'])) ? $this->data['paymentDetails']['paymentProfileName'] : '';       
    }   

    /**
     * @return string The state
     */
    public function getState()
    {            
        return (isset($this->data['paymentDetails']['state'])) ? $this->data['paymentDetails']['state'] : '';       
    }   

    /**
     * @return string The stateName
     */
    public function getStateName()
    {            
        return (isset($this->data['paymentDetails']['stateName'])) ? $this->data['paymentDetails']['stateName'] : '';       
    }   

    /**
     * @return string The language
     */
    public function getLanguage()
    {            
        return (isset($this->data['paymentDetails']['language'])) ? $this->data['paymentDetails']['language'] : '';       
    }   

    /**
     * @return string The startDate
     */
    public function getStartDate()
    {            
        return (isset($this->data['paymentDetails']['startDate'])) ? $this->data['paymentDetails']['startDate'] : '';       
    }   

    /**
     * @return string The completeDate
     */
    public function getCompleteDate()
    {            
        return (isset($this->data['paymentDetails']['completeDate'])) ? $this->data['paymentDetails']['completeDate'] : '';       
    }   

    /**
     * @return string The startIpAddress
     */
    public function getStartIpAddress()
    {            
        return (isset($this->data['paymentDetails']['startIpAddress'])) ? $this->data['paymentDetails']['startIpAddress'] : '';       
    }   

    /**
     * @return string The completedIpAddress
     */
    public function getCompletedIpAddress()
    {            
        return (isset($this->data['paymentDetails']['completedIpAddress'])) ? $this->data['paymentDetails']['completedIpAddress'] : '';       
    }   

    /**
     * @return array The amount value and amount currency
     */
    public function getAmount()
    {            
        return (isset($this->data['paymentDetails']['amount'])) ? $this->data['paymentDetails']['amount'] : '';       
    }   

     /**
     * @return string The amount Value
     */
    public function getAmountValue()
    {            
        return (isset($this->data['paymentDetails']['amount']['value'])) ? $this->data['paymentDetails']['amount']['value'] : '';       
    }  

     /**
     * @return string The amount Currency
     */    
    public function getAmountCurrency()
    {            
        return (isset($this->data['paymentDetails']['amount']['currency'])) ? $this->data['paymentDetails']['amount']['currency'] : '';       
    }  


    /**
     * @return array The amountOriginal value and amountOriginal currency
     */
    public function getAmountOriginal()
    {            
        return (isset($this->data['paymentDetails']['amountOriginal'])) ? $this->data['paymentDetails']['amountOriginal'] : '';       
    }   

     /**
     * @return string The amountOriginal Value
     */
    public function getAmountOriginalValue()
    {            
        return (isset($this->data['paymentDetails']['amountOriginal']['value'])) ? $this->data['paymentDetails']['amountOriginal']['value'] : '';       
    }  

     /**
     * @return string The amountOriginal Currency
     */    
    public function getAmountOriginalCurrency()
    {            
        return (isset($this->data['paymentDetails']['amountOriginal']['currency'])) ? $this->data['paymentDetails']['amountOriginal']['currency'] : '';       
    }  

    /**
     * @return array The amountPaidOriginal value and amountPaidOriginal currency
     */
    public function getAmountPaidOriginal()
    {            
        return (isset($this->data['paymentDetails']['amountPaidOriginal'])) ? $this->data['paymentDetails']['amountPaidOriginal'] : '';       
    }   

     /**
     * @return string The amountPaidOriginal Value
     */
    public function getAmountPaidOriginalValue()
    {            
        return (isset($this->data['paymentDetails']['amountPaidOriginal']['value'])) ? $this->data['paymentDetails']['amountPaidOriginal']['value'] : '';       
    }  

     /**
     * @return string The amountPaidOriginal Currency
     */    
    public function getAmountPaidOriginalCurrency()
    {            
        return (isset($this->data['paymentDetails']['amountPaidOriginal']['currency'])) ? $this->data['paymentDetails']['amountPaidOriginal']['currency'] : '';       
    }  

    /**
     * @return array The amountPaid value and amountPaid currency
     */
    public function getAmountPaid()
    {            
        return (isset($this->data['paymentDetails']['amountPaid'])) ? $this->data['paymentDetails']['amountPaid'] : '';       
    }   

     /**
     * @return string The amountPaid Value
     */
    public function getAmountPaidValue()
    {            
        return (isset($this->data['paymentDetails']['amountPaid']['value'])) ? $this->data['paymentDetails']['amountPaid']['value'] : '';       
    }  

     /**
     * @return string The amountPaid Currency
     */    
    public function getAmountPaidCurrency()
    {            
        return (isset($this->data['paymentDetails']['amountPaid']['currency'])) ? $this->data['paymentDetails']['amountPaid']['currency'] : '';       
    }  

    /**
     * @return array The amountRefundOriginal value and amountRefundOriginal currency
     */
    public function getAmountRefundOriginal()
    {            
        return (isset($this->data['paymentDetails']['amountRefundOriginal'])) ? $this->data['paymentDetails']['amountRefundOriginal'] : '';       
    }  

     /**
     * @return string The amountRefundOriginal Value
     */
    public function getAmountRefundOriginalValue()
    {            
        return (isset($this->data['paymentDetails']['amountRefundOriginal']['value'])) ? $this->data['paymentDetails']['amountRefundOriginal']['value'] : '';       
    }  

     /**
     * @return string The amountRefundOriginal Currency
     */    
    public function getAmountRefundOriginalCurrency()
    {            
        return (isset($this->data['paymentDetails']['amountRefundOriginal']['currency'])) ? $this->data['paymentDetails']['amountRefundOriginal']['currency'] : '';       
    }  

     /**
     * @return array The amountRefund value and amountRefund currency
     */
    public function getAmountRefund()
    {            
        return (isset($this->data['paymentDetails']['amountRefund'])) ? $this->data['paymentDetails']['amountRefund'] : '';       
    }  

     /**
     * @return string The amountRefund Value
     */
    public function getAmountRefundValue()
    {            
        return (isset($this->data['paymentDetails']['amountRefund']['value'])) ? $this->data['paymentDetails']['amountRefund']['value'] : '';       
    }  

     /**
     * @return string The amountRefund Currency
     */    
    public function getAmountRefundCurrency()
    {            
        return (isset($this->data['paymentDetails']['amountRefund']['currency'])) ? $this->data['paymentDetails']['amountRefund']['currency'] : '';       
    }      

    /**
     *  @return array class TransactionDetails[]
     */
    public function getTransactionDetails()
    {
        $arrResult = array();
        $transactionDetails = (isset($this->data['paymentDetails']['transactionDetails'])) ? $this->data['paymentDetails']['transactionDetails'] : array();       

        foreach ($transactionDetails as $arrTransactionDetails) {
            $transactionDetails = new TransactionDetails($arrTransactionDetails);
            array_push($arrResult, $transactionDetails);
        }
        return $arrResult;    
    }        
    
}
