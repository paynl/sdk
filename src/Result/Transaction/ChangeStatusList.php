<?php

namespace Paynl\Result\Transaction;

use Paynl\Result\Result;

class ChangeStatusList extends Result
{
    /**
     * @return boolean
     */
    public function getResult()
    {
        return $this->data['request']['result'];
    }

    /**
     * @return string
     */
    public function getErrorId()
    {
        return $this->data['request']['errorId'];
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->data['request']['errorMessage'];
    }

    /**
     * @return string
     */
    public function getMoreData()
    {
        return $this->data['moreData'];
    }

    /**
     * @return string
     */
    public function getfirstChangeStamp()
    {
        return $this->data['firstChangeStamp'];
    }

    /**
     * @return string
     */
    public function getlastChangeStamp()
    {
        return $this->data['lastChangeStamp'];
    }

    /**
     * @return string
     */
    public function getNumberOfTransactions()
    {
        return $this->data['numberOfTransactions'];
    }

    /**
     * @return array
     */
    public function getTransactions()
    {
        return $this->data['transactions'];
    }
}
