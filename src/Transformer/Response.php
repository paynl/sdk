<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

/**
 * Class Response
 *
 * @package PayNL\Sdk\Transformer
 */
class Response extends AbstractTransformer
{
    public function transform($inputToTransform)
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        if (true === array_key_exists('errors', $inputToTransform)) {
            $this->setModel($this->serviceManager->get('modelManager')->build('Errors'));
        }

        if (null === $this->getModel()) {
            return [];
        }

        return $this->hydrator->hydrate($inputToTransform, $this->getModel());
    }
}
