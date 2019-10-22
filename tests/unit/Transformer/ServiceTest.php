<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    Service as ServiceTransformer,
    TransformerInterface
};
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

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->serviceTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    /**
     * @return void
     */
    public function testItCanTransform(): void
    {
        $input = json_encode([
            'id'          => 'SL-8714-2314',
            'name'        => 'Some service',
            'description' => 'Service description',
            'testMode'    => 0,
            'secret'      => 'jhsnd8ayua8DHJS*9dheq8hrq8rewqrf',
            'createdAt'   => '2019-01-01T08:30:00+02:00',
        ]);

        $output = $this->serviceTransformer->transform($input);
        verify($output)->isInstanceOf(Service::class);
    }
}
