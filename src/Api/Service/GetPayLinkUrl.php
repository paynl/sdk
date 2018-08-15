<?php
namespace Paynl\Api\Service;

class GetPayLinkUrl extends Service
{
    protected $serviceIdRequired = true;

    /**
     * @var int
     */
    private $securityMode;
    /**
     * @var int
     */
    private $amount;
    /**
     * @var int
     */
    private $amountMin;
    /**
     * @var string
     */
    private $countryCode;
    /**
     * @var string
     */
    private $language;
    /**
     * @var array
     */
    private $extra1;
    /**
     * @var array
     */
    private $extra2;
    /**
     * @var array
     */
    private $extra3;
    /**
     * @var string
     */
    private $tool;
    /**
     * @var string
     */
    private $info;

    /**
     * @param int $securityMode
     */
    public function setSecurityMode($securityMode)
    {
        $this->securityMode = (int)$securityMode;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @param int $amountMin
     */
    public function setAmountMin($amountMin)
    {
        $this->amountMin = $amountMin;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @param array $extra1
     */
    public function setExtra1(array $extra1)
    {
        $this->extra1 = $extra1;
    }

    /**
     * @param array $extra2
     */
    public function setExtra2(array $extra2)
    {
        $this->extra2 = $extra2;
    }

    /**
     * @param array $extra3
     */
    public function setExtra3(array $extra3)
    {
        $this->extra3 = $extra3;
    }

    /**
     * @param string $tool
     */
    public function setTool($tool)
    {
        $this->tool = $tool;
    }

    /**
     * @param string $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
    }

    /**
     * @inheritdoc
     */
    protected function getData()
    {
        $data = parent::getData();

        $data['securityMode'] = $this->securityMode;
        $data['amount'] = $this->amount;
        $data['amountMin'] = $this->amountMin;

        if (isset($this->countryCode)) {
            $data['countryCode'] = $this->countryCode;
        }
        if (isset($this->language)) {
            $data['language'] = $this->language;
        }
        if (isset($this->extra1)) {
            $data['extra1'] = $this->extra1;
        }
        if (isset($this->extra2)) {
            $data['extra2'] = $this->extra2;
        }
        if (isset($this->extra3)) {
            $data['extra3'] = $this->extra3;
        }
        if (isset($this->tool)) {
            $data['tool'] = $this->tool;
        }
        if (isset($this->info)) {
            $data['info'] = $this->info;
        }

        return $data;
    }
    /**
     * @param null $endpoint
     * @param null $version
     * @return array
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('Service/getPayLinkUrl');
    }
}
