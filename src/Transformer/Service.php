<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use \Exception;
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
     *
     * @throws Exception
     */
    public function transform($inputToTransform)
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        $hydrator = new ServiceHydrator();
        if (false === array_key_exists('services', $inputToTransform)) {
            // get request
            return $hydrator->hydrate($inputToTransform, new ServiceModel());
        }

        $services = &$inputToTransform['services'];
        foreach ($services as $key => $serviceArray) {
            $service = $hydrator->hydrate($serviceArray, new ServiceModel());
            $services[$key] = $service;
        }

        return $inputToTransform;
    }
}
