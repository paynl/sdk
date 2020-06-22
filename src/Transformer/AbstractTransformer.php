<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Exception\UnexpectedValueException;
use PayNL\Sdk\Model\ModelAwareInterface;
use PayNL\Sdk\Model\ModelAwareTrait;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Zend\Hydrator\HydratorAwareInterface;
use Zend\Hydrator\HydratorAwareTrait;
use PayNL\Sdk\Service\Manager as ServiceManager;

/**
 * Class AbstractTransformer
 *
 * @package PayNL\Sdk\Transformer
 */
abstract class AbstractTransformer implements TransformerInterface, ModelAwareInterface, HydratorAwareInterface
{
    use ModelAwareTrait;
    use HydratorAwareTrait;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @param string $jsonEncodedString
     *
     * @throws UnexpectedValueException
     *
     * @return mixed
     */
    protected function getDecodedInput(string $jsonEncodedString)
    {
        // always expect a JSON-encoded string
        try {
            $transformedInput = (new JsonEncoder())->decode($jsonEncodedString, 'json');
        } catch (NotEncodableValueException $notEncodableValueException) {
            throw new UnexpectedValueException('Unable to decode the response', 500, $notEncodableValueException);
        }

        return $this->filterNotNull($transformedInput);
    }

    /**
     * @param array $input
     *
     * @return array
     */
    protected function filterNotNull(array $input): array
    {
        $context = $this;

        return array_filter(
            array_map(static function ($item) use ($context) {
                return is_array($item) === true ? $context->filterNotNull($item) : $item;
            }, $input),
            static function ($item) {
                return $item !== '' && $item !== null;
            }
        );
    }
}
