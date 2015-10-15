<?php
/*
 * Copyright (C) 2015 Pay.nl
 */

namespace Paynl;

use Paynl\Config;
use Paynl\Error;
/**
 * Description of Helper
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Helper
{

    public static function requireApiToken()
    {
        if (empty(Config::getApiToken())) {
            throw new Error\Required\ApiToken();
        }
    }

    public static function requireServiceId()
    {
        if (empty(Config::getServiceId())) {
            throw new Error\Required\ServiceId();
        }
    }

    public static function getIp()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    public static function getBrowserData()
    {
        return array(
            'browser_name_regex' => '^mozilla/5\.0 (windows; .; windows nt 5\.1; .*rv:.*) gecko/.* firefox/0\.9.*$',
            'browser_name_pattern' => 'Mozilla/5.0 (Windows; ?; Windows NT 5.1; *rv:*) Gecko/* Firefox/0.9*',
            'parent' => 'Firefox 0.9',
            'platform' => 'WinXP',
            'browser' => 'Firefox',
            'version' => 0.9,
            'majorver' => 0,
            'minorver' => 9,
            'cssversion' => 2,
            'frames' => 1,
            'iframes' => 1,
            'tables' => 1,
            'cookies' => 1,
        );
        ;
    }
}