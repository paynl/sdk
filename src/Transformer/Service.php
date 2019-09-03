<?php
declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Hydrator\Service as ServiceHydrator;
use PayNL\Sdk\Model\Service as ServiceModel;

/**
 * Class Service
 *
 * @package PayNL\Sdk\Transformer
 */
class Service extends AbstractTransformer
{
    /**
     * @inheritDoc
     */
    public function transform($inputToTransform)
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        $hydrator = new ServiceHydrator();

        $transactions = &$inputToTransform['services'];
        foreach ($transactions as $key => $transactionArray) {
            $transaction = $hydrator->hydrate($transactionArray, new ServiceModel());
            $transactions[$key] = $transaction;
        }

        return $inputToTransform;
    }
}
