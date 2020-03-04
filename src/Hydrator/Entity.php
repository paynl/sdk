<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use Doctrine\Common\Collections\ArrayCollection;
use PayNL\Sdk\{
    Common\CollectionInterface,
    Exception\LogicException,
    Exception\RuntimeException,
    Model\ModelInterface
};
use ReflectionClass,
    ReflectionProperty,
    ReflectionException
;

/**
 * Class Entity
 *
 * @package PayNL\Sdk\Hydrator
 */
class Entity extends AbstractHydrator
{
    /**
     * @var array
     */
    protected $collectionMap = [
        // CollectionEntity(Alias) => EntryEntity(Alias)
        'contactMethods' => 'contactMethod',
        'currencies'     => 'currency',
        'directdebits'   => 'directdebit',
        'errors'         => 'error',
        'links'          => 'link',
        'paymentMethods' => 'paymentMethod',
        'products'       => 'product',
        'services'       => 'service',
        'terminals'      => 'terminal',
        'trademarks'     => 'trademark',
    ];

    protected $scalarTypes = [
        'string',
        'int',
        'integer',
        'float',
        'bool',
        'boolean',
        'array',
    ];

    /**
     * Get the property info for the given model based on the
     *  annotation tag "@var"
     *
     * @param ModelInterface $model
     *
     * @throws LogicException when a property within the object does not have a DocBlock
     *
     * @return array
     */
    public function load(ModelInterface $model): array
    {
        $ref = null;
        try {
            $ref = new ReflectionClass($model);
        } catch (ReflectionException $re) {
            // do nothing, model always exist
            throw new RuntimeException(
                sprintf(
                    'Can not load model "%s"',
                    get_class($model)
                )
            );
        }

        $properties = $ref->getProperties();

        $propertyInfo = [];
        /** @var ReflectionProperty $property */
        foreach ($properties as $property) {
            $docComment = $property->getDocComment();
            if (false === $docComment) {
                throw new LogicException(
                    sprintf(
                        'Doc comment missing for "%s" in "%s"',
                        $property->getName(),
                        get_class($model)
                    )
                );
            }
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

    /**
     * @param array $data
     * @param object $object
     *
     * @throws RuntimeException when given object isn't an instance of ModelInterface
     *
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        if (false === ($object instanceof ModelInterface)) {
            throw new RuntimeException(
                sprintf(
                    'Given object "%s" to "%s" is not an instance of "%s"',
                    get_class($object),
                    __METHOD__,
                    ModelInterface::class
                )
            );
        }

        if (true === array_key_exists('_links', $data)) {
            $data['links'] = $data['_links'];
            unset($data['_links']);
        }

        /** @var ModelInterface $object */
        $propertyInfo = $this->load($object);

        foreach ($data as $key => $value) {
            $type = $propertyInfo[$key] ?? 'string';
            if (false === in_array($type, $this->scalarTypes, true)) {
                if ($type === 'DateTime') {
                    $data[$key] = $this->getSdkDateTime($value);
                    continue;
                }

                $data[$key] = $this->hydratorManager->build(static::class)
                    ->hydrate($value, $this->modelManager->build($type))
                ;
            }
        }

        if ($object instanceof CollectionInterface) {
            $collectionKey = $object->getCollectionName();
            if (false === array_key_exists($collectionKey, $data)) {
                // assume the given array are necessary single entities
                $data = [
                    $collectionKey => $data,
                ];
            }

            $singleName = $this->collectionMap[$collectionKey];
            $collection = $data[$collectionKey] ?? [];
            foreach ($collection as $key => $entryData) {
                $data[$collectionKey][$key] = $this->hydratorManager->build(static::class)
                    ->hydrate($entryData, $this->modelManager->build($singleName))
                ;
            }

            return parent::hydrate($data, $object);
        }

        return parent::hydrate($data, $object);
    }

    /**
     * @inheritDoc
     */
    public function extract($object): array
    {
        $data = parent::extract($object);
        foreach ($data as $name => $value) {
            if ($value instanceof ArrayCollection) {
                $data[$name] = $value->toArray();
            } elseif (true === is_object($value)) {
                $data[$name] = $this->extract($value);
            }
        }
        return $data;
    }
}
