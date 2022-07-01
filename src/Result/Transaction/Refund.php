<?php

namespace Paynl\Result\Transaction;

use Paynl\Result\Result;

/**
 * Result class for a refund
 *
 * @author PAY. <support@pay.nl>
 */
class Refund extends Result
{   

    /**
     * @return string The description
     */
    public function getDescription()
    {            
        return (isset($this->data['description'])) ? $this->data['description'] : '';       
    }

    /**
     * @return array The refund array, fields: orderId, amount and refundAmount
     */
    public function getRefundedTransaction()
    {
        $refundedTransaction = array();
        if (isset($this->data['refundedTransactions'])) {
            $refundedTransaction = $this->data['refundedTransactions'];
        }
        return $refundedTransaction;
    }   
    
    /**
     * @return string The orderId
     */
    public function getOrderId()
    {     
        $refundedTransaction = $this->getRefundedTransaction();
        return (isset($refundedTransaction['orderId'])) ? $refundedTransaction['orderId'] : '';       
    }
    
    /**
     * @return string The total amount paid for the transaction
     */
    public function getAmount()
    {     
        $refundedTransaction = $this->getRefundedTransaction();
        return (isset($refundedTransaction['amount'])) ? $refundedTransaction['amount'] : '';       
    }
    
    /**
     * @return string The refundAmount
     */
    public function getRefundAmount()
    {     
        $refundedTransaction = $this->getRefundedTransaction();
        return (isset($refundedTransaction['refundAmount'])) ? $refundedTransaction['refundAmount'] : '';       
    }

    /**
     * @return string The bankaccountNumber
     */
    public function getBankaccountNumber()
    {     
        $refundedTransaction = $this->getRefundedTransaction();
        return (isset($refundedTransaction['bankaccountNumber'])) ? $refundedTransaction['bankaccountNumber'] : '';       
    }

    /**
     * @return string The refundId
     */
    public function getRefundId()
    {     
        $refundedTransaction = $this->getRefundedTransaction();
        return (isset($refundedTransaction['refundId'])) ? $refundedTransaction['refundId'] : '';       
    }

    /**
     * @return array Returns the failed refund transactions
     */
    public function getFailedTransactions()
    {
        return isset($this->data['failedTransactions']) ? $this->data['failedTransactions'] : array();
    }

}