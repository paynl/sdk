<?php

namespace Paynl\Result\Transaction;

use Paynl\Result\Result;

/**
 * Result class for a Details
 *
 * @author PAY. <support@pay.nl>
 */
class TransactionDetails extends Result
{      


    /**
     * @return string The transactionId
     */
    public function getTransactionId()
    {            
        return (isset($this->data['transactionId'])) ? $this->data['transactionId'] : '';       
    }   

    /**
     * @return string The orderId
     */
    public function getOrderId()
    {            
        return (isset($this->data['orderId'])) ? $this->data['orderId'] : '';       
    }   

    /**
     * @return string The reportingId
     */
    public function getReportingId()
    {            
        return (isset($this->data['reportingId'])) ? $this->data['reportingId'] : '';       
    }  

    /**
     * @return string The state
     */
    public function getState()
    {            
        return (isset($this->data['state'])) ? $this->data['state'] : '';       
    }   

    /**
     * @return string The stateName
     */
    public function getStateName()
    {            
        return (isset($this->data['stateName'])) ? $this->data['stateName'] : '';       
    }   

    /**
     * @return string The startDate
     */
    public function getStartDate()
    {            
        return (isset($this->data['startDate'])) ? $this->data['startDate'] : '';       
    }   

    /**
     * @return string The completeDate
     */
    public function getCompleteDate()
    {            
        return (isset($this->data['completeDate'])) ? $this->data['completeDate'] : '';       
    }  

    /**
     * @return string The paymentProfileId
     */
    public function getPaymentProfileId()
    {            
        return (isset($this->data['paymentProfileId'])) ? $this->data['paymentProfileId'] : '';       
    }   

    /**
     * @return string The paymentProfileName
     */
    public function getPaymentProfileName()
    {            
        return (isset($this->data['paymentProfileName'])) ? $this->data['paymentProfileName'] : '';       
    }   

    /**
     * @return string The identifierName
     */
    public function getIdentifierName()
    {            
        return (isset($this->data['identifierName'])) ? $this->data['identifierName'] : '';       
    } 

    /**
     * @return string The identifierType
     */
    public function getIdentifierType()
    {            
        return (isset($this->data['identifierType'])) ? $this->data['identifierType'] : '';       
    } 

    /**
     * @return string The identifierPublic
     */
    public function getIdentifierPublic()
    {            
        return (isset($this->data['identifierPublic'])) ? $this->data['identifierPublic'] : '';       
    } 

    /**
     * @return string The identifierHash
     */
    public function getIdentifierHash()
    {            
        return (isset($this->data['identifierHash'])) ? $this->data['identifierHash'] : '';       
    } 

    /**
     * @return array The amount value and amount currency
     */
    public function getAmount()

    {            
        return (isset($this->data['amount'])) ? $this->data['amount'] : '';       
    }   

     /**
     * @return string The amount Value
     */
    public function getAmountValue()
    {            
        return (isset($this->data['amount']['value'])) ? $this->data['amount']['value'] : '';       
    }  

     /**
     * @return string The amount Currency
     */    
    public function getAmountCurrency()
    {            
        return (isset($this->data['amount']['currency'])) ? $this->data['amount']['currency'] : '';       
    }  


    
}
