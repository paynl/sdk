<?php

namespace Paynl\Api\Payment\Model;

class Browser extends Model
{
    /**
     * @var string
     */
    private $javaEnabled;

    /**
     * @var string
     */
    private $javascriptEnabled;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $colorDepth;

    /**
     * @var string
     */
    private $screenHeight;

    /**
     * @var string
     */
    private $screenWidth;

    /**
     * @var string
     */
    private $tz;

    /**
     * @return mixed
     */
    public function getJavaEnabled()
    {
        return $this->javaEnabled;
    }

    /**
     * @param string $javaEnabled
     * @return static
     */
    public function setJavaEnabled($javaEnabled)
    {
        $this->javaEnabled = $javaEnabled;
        return $this;
    }

    /**
     * @return string
     */
    public function getJavascriptEnabled()
    {
        return $this->javascriptEnabled;
    }

    /**
     * @param string $javascriptEnabled
     * @return static
     */
    public function setJavascriptEnabled($javascriptEnabled)
    {
        $this->javascriptEnabled = $javascriptEnabled;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return static
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return string
     */
    public function getColorDepth()
    {
        return $this->colorDepth;
    }

    /**
     * @param string $colorDepth
     * @return static
     */
    public function setColorDepth($colorDepth)
    {
        $this->colorDepth = $colorDepth;
        return $this;
    }

    /**
     * @return string
     */
    public function getScreenHeight()
    {
        return $this->screenHeight;
    }

    /**
     * @param string $screenHeight
     * @return static
     */
    public function setScreenHeight($screenHeight)
    {
        $this->screenHeight = $screenHeight;
        return $this;
    }

    /**
     * @return string
     */
    public function getScreenWidth()
    {
        return $this->screenWidth;
    }

    /**
     * @param string $screenWidth
     * @return static
     */
    public function setScreenWidth($screenWidth)
    {
        $this->screenWidth = $screenWidth;
        return $this;
    }

    /**
     * Timezone
     * @return string
     */
    public function getTz()
    {
        return $this->tz;
    }

    /**
     * Timezone
     * @param string $tz
     * @return static
     */
    public function setTz($tz)
    {
        $this->tz = $tz;
        return $this;
    }
}