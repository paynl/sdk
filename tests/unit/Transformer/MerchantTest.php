<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    Merchant as MerchantTransformer,
    TransformerInterface
};
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Model\Merchant;
use Exception;

/**
 * Class MerchantTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class MerchantTest extends UnitTest
{
    /**
     * @var MerchantTransformer
     */
    protected $merchantTransformer;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->merchantTransformer = new MerchantTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->merchantTransformer)->isInstanceOf(TransformerInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->merchantTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanTransform(): void
    {
        $input = json_encode([
            'id'             => 'M-1000-0001',
            'name'           => 'Pay.nl',
            'coc'            => '24283498',
            'vat'            => 'NL807960147B01',
            'website'        => 'http://www.pay.nl',
            'bankAccount'    => [
                'iban'  => 'NL05RABO0352224037',
                'bic'   => 'RABONL2U',
                'owner' => 'TinTel BV',
            ],
            'postalAddress'  => [
                'initials'              => 'C',
                'lastName'              => 'Kent',
                'streetName'            => 'Jan Campertlaan',
                'streetNumber'          => 10,
                'streetNumberExtension' => '',
                'zipCode'               => '3201 AX',
                'city'                  => 'Spijkenisse',
                'regionCode'            => 'ZH',
                'countryCode'           => 'NL',
            ],
            'visitAddress'   => [
                'initials'              => 'C',
                'lastName'              => 'Kent',
                'streetName'            => 'Jan Campertlaan',
                'streetNumber'          => 10,
                'streetNumberExtension' => '',
                'zipCode'               => '3201 AX',
                'city'                  => 'Spijkenisse',
                'regionCode'            => 'ZH',
                'countryCode'           => 'NL',
            ],
            'trademarks'     => [
                [
                    'id'        => 'PAY.',
                    'trademark' => 'TM-1234-1234',
                ],
            ],
            'contactMethods' => [
                [
                    'type'        => 'email',
                    'value'       => 'support@pay.nl',
                    'description' => 'Support desk',
                ],
            ],
            'createdAt'      => DateTime::createFromFormat(DateTime::ATOM, '2007-09-10T13:26:26+02:00'),
        ]);

        $output = $this->merchantTransformer->transform($input);
        verify($output)->isInstanceOf(Merchant::class);
    }
}
