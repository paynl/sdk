<?php

namespace Paynl\Api\DirectDebit;

use Paynl\Error\Required;

class RecurringAdd extends MandateAdd
{
    /**
     * @var int Need for recurring part, if intervalValue is 2 and intervalPeriod is 1 than process the directdebit every two weeks
     */
    private $_intervalValue;

    /**
     * @var int 1 : Week, 2 : Month, 3: Quarter, 4 : Half year, 5: Year, 6: Day
     */
    private $_intervalPeriod;

    /**
     * @param int $intervalValue Need for recurring part, if intervalValue is 2 and intervalPeriod is 1 than process the directdebit every two weeks
     */
    public function setIntervalValue($intervalValue)
    {
        $this->_intervalValue = $intervalValue;
    }

    /**
     * @param int $intervalPeriod 1 : Week, 2 : Month, 3: Quarter, 4 : Half year, 5: Year, 6: Day
     */
    public function setIntervalPeriod($intervalPeriod)
    {
        $this->_intervalPeriod = $intervalPeriod;
    }

    /**
     * @inheritdoc
     * @throws Required intervalValue is required
     * @throws Required intervalPeriod is required
     */
    public function getData()
    {
        if (empty($this->_intervalValue)) {
            throw new Required('intervalValue');
        }
        if (empty($this->_intervalPeriod)) {
            throw new Required('intervalPeriod');
        }

        $this->data['intervalValue'] = $this->_intervalValue;
        $this->data['intervalPeriod'] = $this->_intervalPeriod;

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = 'DirectDebit/recurringAdd', $version = null)
    {
        return parent::doRequest($endpoint, $version);
    }
}
