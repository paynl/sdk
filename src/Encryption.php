<?php
namespace Paynl;

use Paynl\Api\Encryption\PublicKeys;

/**
 * Description of Encryption
 */
class Encryption
{
    /**
     * Obtain cryptographic keys to use.
     *
     * @return string
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     */
    public static function publicKeys()
    {
        $api = new PublicKeys();

        return $api->doRequest();
    }
}
