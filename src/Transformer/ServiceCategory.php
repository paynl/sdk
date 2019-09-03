<?php
declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Model\ServiceCategory as ServiceCategoryModel;
use Zend\Hydrator\ClassMethods;

/**
 * Class ServiceCategory
 *
 * @package PayNL\Sdk\Transformer
 */
class ServiceCategory extends AbstractTransformer
{
    /**
     * @inheritDoc
     */
    public function transform($inputToTransform)
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        $hydrator = new ClassMethods();

        $categories = &$inputToTransform['categories'];
        foreach ($categories as $key => $transactionArray) {
            $transaction = $hydrator->hydrate($transactionArray, new ServiceCategoryModel());
            $categories[$key] = $transaction;
        }

        return $inputToTransform;
    }
}
