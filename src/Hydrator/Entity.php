<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use Doctrine\Common\Collections\ArrayCollection;
use PayNL\Sdk\Exception\LogicException;
use ReflectionClass, ReflectionProperty, ReflectionException;

/**
 * Class Entity
 *
 * @package PayNL\Sdk\Hydrator
 */
class Entity extends AbstractHydrator
{
    protected $collectionMap = [
        'currencies' => 'currency',
        'errors' => 'error',
        'terminals' => 'terminal',
        'links' => 'link',
        'paymentMethods' => 'paymentMethod',
        'products' => 'product',
        'services' => 'service',
        'trademarks' => 'trademark',
        'contactMethods' => 'contactMethod',
    ];

    public function load($model)
    {
        $ref = null;
        try {
            $ref = new ReflectionClass($model);
        } catch (ReflectionException $re) {
            // do nothing, model always exist
        }

        $properties = $ref->getProperties();

        $propertyInfo = [];
        /** @var ReflectionProperty $property */
        foreach ($properties as $property) {
            $docComment = $property->getDocComment();
            if (1 !== preg_match("/@var(?:\n|\s(?P<type>.+)\n)/s", $docComment, $annotations)) {
                throw new LogicException(
                    sprintf(
                        'Property %s on %s does not have a proper type annotation',
                        $property->getName(),
                        get_class($model)
                    )
                );
            }
            $propertyInfo[$property->getName()] = $annotations['type'];
        }
        return $propertyInfo;
    }

    public function hydrate(array $data, $object)
    {
        if (true === array_key_exists('_links', $data)) {
            $data['links'] = $data['_links'];
            unset($data['_links']);
        }

        if (true === $this->isDebug()) {
//            $this->dumpDebugInfo('Given data for ' . get_class($object), $data);
        }

        $propertyInfo = $this->load($object);
        if (true === $this->isDebug()) {
//            $this->dumpDebugInfo('Property info of ' . get_class($object), $propertyInfo);
        }

        $scalarTypes = [
            'string',
            'int',
            'integer',
            'float',
            'bool',
            'boolean',
            'array',
        ];

        foreach ($data as $key => $value) {
            $type = $propertyInfo[$key] ?? 'string';
            if (false === in_array($type, $scalarTypes, true)) {
                if ($type === 'DateTime') {
                    $data[$key] = $this->getSdkDateTime($value);
                    continue;
                }

                $data[$key] = $this->hydratorManager->build(static::class)
                    ->hydrate($value, $this->modelManager->build($type))
                ;
            }
        }

        if ($object instanceof ArrayCollection) {
            $collectionKey = $object->getCollectionName();
            if (false === array_key_exists($collectionKey, $data)) {
                // assume the given array are currencies
                $data = [
                    $collectionKey => $data,
                ];
            }

            $singleName = $this->collectionMap[$collectionKey];
            foreach ($data[$collectionKey] as $key => $currency) {
                $data[$collectionKey][$key] = $this->hydratorManager->build(static::class)
                    ->hydrate($currency, $this->modelManager->build($singleName))
                ;
            }

            return parent::hydrate($data, $object);
        }

        return parent::hydrate($data, $object);
    }
}
