<?php

namespace Paynl\Result\Transaction;

use Paynl\Error\Error;
use Paynl\Result\Result;

/**
 * Description of Transaction
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Transaction extends Result
{
    private $_cachedStatusResult = null;

    /**
     * @return bool Transaction is paid
     */
    public function isPaid()
    {
        return $this->data['paymentDetails']['stateName'] === 'PAID';
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return $this->data['paymentDetails']['stateName'] === 'PENDING' || $this->data['paymentDetails']['stateName'] === 'VERIFY';
    }

    /**
     * Alias for isCanceled
     *
     * @return bool Transaction is Canceled
     */
    public function isCancelled()
    {
        return $this->isCanceled();
    }

  /**
   *
   * Check whether the status of the transaction is chargeback
   *
   * @return bool
   */
    public function isChargeBack()
    {
      return $this->data['paymentDetails']['stateName'] === 'CHARGEBACK';
    }

    /**
     * @return bool Transaction is Canceled
     */
    public function isCanceled()
    {
        return $this->data['paymentDetails']['state'] < 0;
    }

    public function void()
    {
        if (!$this->isAuthorized()) {
            throw new Error('Cannod void transaction, status is not authorized');
        }

        return \Paynl\Transaction::void($this->getId());
    }

    public function isAuthorized()
    {
        return $this->data['paymentDetails']['state'] == 95;
    }

    /**
     * @return string The transaction id
     */
    public function getId()
    {
        return $this->data['transactionId'];
    }

    public function capture()
    {
        if (!$this->isAuthorized()) {
            throw new Error('Cannod capture transaction, status is not authorized');
        }

        return \Paynl\Transaction::capture($this->getId());
    }

    /**
     * @param bool|true $allowPartialRefunds
     *
     * @return bool
     */
    public function isRefunded($allowPartialRefunds = true)
    {
        if ($this->data['paymentDetails']['stateName'] === 'REFUND') {
            return true;
        }

        if ($allowPartialRefunds && $this->data['paymentDetails']['stateName'] === 'PARTIAL_REFUND') {
            return true;
        }

        return false;
    }

    /**
     * Check whether the payment is partial refunded
     *
     * @return bool
     */
    public function isPartiallyRefunded()
    {
        return $this->data['paymentDetails']['stateName'] === 'PARTIAL_REFUND';
    }

  /**
   * Check whether the payment is a partial payment.
   *
   * @return bool
   */
    public function isPartialPayment()
    {
        return $this->data['paymentDetails']['stateName'] === 'PARTIAL_PAYMENT';
    }

    /**
     * @return float|int The order amount
     */
    public function getAmount()
    {
        return $this->data['paymentDetails']['amount']['value'] / 100;
    }

    /**
     * @return string The currency of getAmount()
     */
    public function getCurrency()
    {
        return $this->data['paymentDetails']['amount']['currency'];
    }

    /**
     * @return float|int The original amount
     */
    public function getAmountOriginal()
    {
        return $this->data['paymentDetails']['amountOriginal']['value'] / 100;
    }

    /**
     * @return string The currency of getAmountOriginal()
     */
    public function getAmountOriginalCurrency()
    {
        return $this->data['paymentDetails']['amountOriginal']['currency'];
    }

    /**
     * @return float|int The original paid amount
     */
    public function getAmountPaidOriginal()
    {
        return $this->data['paymentDetails']['amountPaidOriginal']['value'] / 100;
    }

    /**
     * @return string The currency of getAmountPaidOriginal()
     */
    public function getAmountPaidOriginalCurrency()
    {
        return $this->data['paymentDetails']['amountPaidOriginal']['currency'];
    }

    /**
     * @return float|int The paid amount
     */
    public function getAmountPaid()
    {
        return $this->data['paymentDetails']['amountPaid']['value'] / 100;
    }

    /**
     * @return string The currency of getAmountPaid()
     */
    public function getAmountPaidCurrency()
    {
        return $this->data['paymentDetails']['amountPaid']['currency'];
    }

    /**
     * @return string The name of the account holder
     */
    public function getAccountHolderName()
    {
        return $this->data['paymentDetails']['identifierName'];
    }

    /**
     * @return string The name of the payment method
     */
    public function getPaymentMethodName()
    {
        return $this->data['paymentDetails']['paymentProfileName'];
    }

    /**
     * @return string The account number, or masked creditcard number
     */
    public function getAccountNumber()
    {
        return $this->data['paymentDetails']['identifierPublic'];
    }

    /**
     * @return string The account number, or masked creditcard number
     */
    public function getAccountHash()
    {
        return $this->data['paymentDetails']['identifierHash'];
    }

    /**
     * @return string The transaction description, as defined while starting the transaction
     */
    public function getDescription()
    {
        return $this->data['paymentDetails']['description'];
    }

    /**
     * @return string The extra1 variable, as defined while starting the transaction
     */
    public function getExtra1()
    {
        return $this->data['statsDetails']['extra1'];
    }

    /**
     * @return string The extra2 variable, as defined while starting the transaction
     */
    public function getExtra2()
    {
        return $this->data['statsDetails']['extra2'];
    }

    /**
     * @return string The extra3 variable, as defined while starting the transaction
     */
    public function getExtra3()
    {
        return $this->data['statsDetails']['extra3'];
    }

    /**
     * @return float|int The refunded amount in euro
     * @throws Error
     * @throws \Paynl\Error\Api
     */
    public function getRefundedAmount()
    {
        return $this->getStatus()->getAmountRefund();
    }

    /**
     * @return float|int The refunded amount in the used currency
     * @throws Error
     * @throws \Paynl\Error\Api
     */
    public function getRefundedCurrencyAmount()
    {
        return $this->getStatus()->getAmountRefundCurrency();
    }

    public function approve()
    {
        if (!$this->isBeingVerified()) {
            throw new Error("Cannot approve transaction because it does not have the status 'verify'");
        }

        $result = \Paynl\Transaction::approve($this->getId());
        $this->_reload(); //status is changed, so refresh the object

        return $result;
    }

    /**
     * @return Status
     * @throws Error
     * @throws \Paynl\Error\Api
     */
    public function getStatus()
    {
        if (is_null($this->_cachedStatusResult)) {
            $this->_cachedStatusResult = \Paynl\Transaction::status($this->getId());
        }
        return $this->_cachedStatusResult;
    }

    /**
     * @return bool
     */
    public function isBeingVerified()
    {
        return $this->data['paymentDetails']['stateName'] === 'VERIFY';
    }

    private function _reload()
    {
        $this->_cachedStatusResult = null;
        $result = \Paynl\Transaction::get($this->getId());
        $this->data = $result->getData();
    }

    public function decline()
    {
        if (!$this->isBeingVerified()) {
            throw new Error("Cannot decline transaction because it does not have the status 'verify'");
        }

        $result = \Paynl\Transaction::decline($this->getId());
        $this->_reload();//status is changed, so refresh the object

        return $result;
    }
}
