<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    ServiceCategory as ServiceCategoryTransformer,
    TransformerInterface
};
use PayNL\Sdk\Model\ServiceCategory;

/**
 * Class ServiceCategoryTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class ServiceCategoryTest extends UnitTest
{
    /**
     * @var ServiceCategoryTransformer
     */
    protected $serviceCategoryTransformer;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->serviceCategoryTransformer = new ServiceCategoryTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->serviceCategoryTransformer)->isInstanceOf(TransformerInterface::class);
    }

    public function testItExtendsAbstract(): void
    {
        verify($this->serviceCategoryTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    public function testItCanTransformMultiple(): void
    {
        $input = json_encode([
            'categories' => [
                [
                    'id'          => 1000,
                    'name'        => 'Category #1',
                ],
                [
                    'id'          => 1010,
                    'name'        => 'Category #2',
                ],
            ],
        ]);

        $output = $this->serviceCategoryTransformer->transform($input);
        verify($output)->array();
        verify($output)->hasKey('categories');
        verify($output['categories'])->array();
        verify($output['categories'])->count(2);
        verify($output['categories'])->containsOnlyInstancesOf(ServiceCategory::class);
    }
}
