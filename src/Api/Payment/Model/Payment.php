<?php

namespace Paynl\Api\Payment\Model;

class Payment extends Model
{
    const METHOD_CSE = 'cse';

    /**
     * @var string
     */
    private $method;

    /**
     * @var CSE
     */
    private $cse;

    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var Card
     */
    private $card;

    /**
     * @var Browser
     */
    private $browser;

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return static
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return CSE
     */
    public function getCse()
    {
        return $this->cse;
    }

    /**
     * @param CSE $cse
     * @return static
     */
    public function setCse($cse)
    {
        $this->cse = $cse;
        return $this;
    }

    /**
     * @return Card
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param Card $card
     * @return static
     */
    public function setCard($card)
    {
        $this->card = $card;
        return $this;
    }

    /**
     * @return Browser
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * @param Browser $browser
     * @return static
     */
    public function setBrowser($browser)
    {
        $this->browser = $browser;
        return $this;
    }

    /**
     * @return Auth
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @param Auth $auth
     * @return static
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
        return $this;
    }
}