<?php

namespace Paynl\Result\Transaction;

use Paynl\Result\Result;

/**
 * Result class for a Cancel
 *
 * @author PAY. <support@pay.nl>
 */
class Cancel extends Result
{

    /**
     * @return mixed|string
     */
    public function getStatusAction()
    {
        return (isset($this->data['transaction']['statusAction'])) ? $this->data['transaction']['statusAction'] : '';
    }

    /**
     * @return bool
     */
    public function isSucceeded()
    {
        return $this->getStatusAction() === 'CANCEL';
    }
}
