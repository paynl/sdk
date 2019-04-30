<?php

namespace Paynl\Result\Refund;

use Paynl\Result\Result;

/**
 * Description of Refund
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Refund extends Result
{
    /**
     * @return string The Refund id
     */
    public function getId()
    {
        return $this->data['refundId'];
    }

    public function isRefunded()
    {
        return $this->data['refund']['statusName'] == 'Verwerkt';
    }

    public function getRefund()
    {
        return $this->data['refund'];
    }
}
