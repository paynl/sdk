<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    Services as ServicesTransformer,
    TransformerInterface
};
use PayNL\Sdk\Model\{
    Services,
    Service
};

/**
 * Class ServicesTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class ServicesTest extends UnitTest
{
    /**
     * @var ServicesTransformer
     */
    protected $servicesTransformer;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->servicesTransformer = new ServicesTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->servicesTransformer)->isInstanceOf(TransformerInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->servicesTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    /**
     * @return void
     */
    public function testItCanTransform(): void
    {
        $input = json_encode([
            'services' => [
                [
                    'id'          => 'SL-8714-2314',
                    'name'        => 'Some service',
                    'description' => 'Service description',
                    'testMode'    => 0,
                    'secret'      => 'jhsnd8ayua8DHJS*9dheq8hrq8rewqrf',
                    'createdAt'   => '2019-01-01T08:30:00+02:00',
                ],
                [
                    'id'          => 'SL-8714-2323',
                    'name'        => 'Some other service',
                    'testMode'    => 1,
                    'secret'      => 'jhsnd8ayua8sdEW$R#@$JS*SDJsIFe99',
                    'createdAt'   => '2019-03-31T10:14:57+02:00',
                ],
            ],
        ]);

        $output = $this->servicesTransformer->transform($input);
        verify($output)->isInstanceOf(Services::class);
        verify($output)->count(2);
        verify($output)->containsOnlyInstancesOf(Service::class);
    }
}
