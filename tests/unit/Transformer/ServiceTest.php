<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    Service as ServiceTransformer,
    TransformerInterface
};
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Model\Service;

/**
 * Class ServiceTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class ServiceTest extends UnitTest
{
    /**
     * @var ServiceTransformer
     */
    protected $serviceTransformer;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->serviceTransformer = new ServiceTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->serviceTransformer)->isInstanceOf(TransformerInterface::class);
    }

    public function testItExtendsAbstract(): void
    {
        verify($this->serviceTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    public function testItCanTransformMultiple(): void
    {
        $input = json_encode([
            'services' => [
                [
                    'id'          => 'SL-8714-2314',
                    'name'        => 'Some service',
                    'description' => 'Service description',
                    'testMode'    => 0,
                    'secret'      => 'jhsnd8ayua8DHJS*9dheq8hrq8rewqrf',
                    'createdAt'   => DateTime::createFromFormat('Y-m-d H:i:s', '2019-01-01 08:30:00'),
                ],
                [
                    'id'          => 'SL-8714-2323',
                    'name'        => 'Some other service',
                    'testMode'    => 1,
                    'secret'      => 'jhsnd8ayua8sdEW$R#@$JS*SDJsIFe99',
                    'createdAt'   => DateTime::createFromFormat('Y-m-d H:i:s', '2019-03-31 10:14:57'),
                ],
            ],
        ]);

        $output = $this->serviceTransformer->transform($input);
        verify($output)->array();
        verify($output)->hasKey('services');
        verify($output['services'])->array();
        verify($output['services'])->containsOnlyInstancesOf(Service::class);
    }

    public function testItCanTransformSingle(): void
    {
        $input = json_encode([
            'id'          => 'SL-8714-2314',
            'name'        => 'Some service',
            'description' => 'Service description',
            'testMode'    => 0,
            'secret'      => 'jhsnd8ayua8DHJS*9dheq8hrq8rewqrf',
            'createdAt'   => DateTime::createFromFormat('Y-m-d H:i:s', '2019-01-01 08:30:00'),
        ]);

        $output = $this->serviceTransformer->transform($input);
        verify($output)->isInstanceOf(Service::class);
    }
}
