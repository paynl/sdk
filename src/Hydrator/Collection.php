<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Config;
use PayNL\Sdk\Model;

/**
 * Class Collection
 *
 * @package PayNL\Sdk\Hydrator
 */
class _Collection extends AbstractHydrator
{
//    /**
//     * @var string
//     */
//    protected $collectionKey;
//
//    /**
//     * @inheritDoc
//     *
//     * @param string $collectionKey
//     */
//    public function __construct(array $options = [], $underscoreSeparatedKeys = true, $methodExistsCheck = false)
//    {
//        $this->setCollectionKey($options['key'] ?? '');
//
//        parent::__construct($underscoreSeparatedKeys, $methodExistsCheck);
//    }

//    /**
//     * @return string
//     */
//    public function getCollectionKey(): string
//    {
//        return $this->collectionKey;
//    }
//
//    /**
//     * @param string $collectionKey
//     *
//     * @return Collection
//     */
//    protected function setCollectionKey(string $collectionKey): self
//    {
//        $this->collectionKey = $collectionKey;
//        return $this;
//    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        dump($data);die;


//        $collectionKey   = $this->getCollectionKey();
//        dump($object);die;
//        $entityClassName = $this->getEntityClassName(get_class($object));

//        $this->validateGivenObject($object, $this->getCollectionClassName());

//        if (false === array_key_exists($collectionKey, $data)) {
            // the key is not given, assume the data belongs to the requested key
//            $data = [
//                $collectionKey => $data,
//            ];
//        }

//        $hydrators = Config::getInstance()->getMapping(Config::KEY_HYDRATOR_MAPPING);
//        /** @var AbstractHydrator $entityHydrator */
//        $entityHydrator = new $hydrators[$entityClassName]();
//        foreach ($data[$collectionKey] as $key => $currency) {
//            $data[$collectionKey][$key] = $entityHydrator->hydrate($currency, new $entityClassName());
//        }

        return parent::hydrate($data, $object);
    }

//    protected function getEntityClassName($collectionClassName)
//    {
//        $mapping = [
//            Model\Currencies::class => Model\Currency::class,
//            Model\Errors::class => Model\Error::class,
//            Model\Links::class => Model\Link::class,
//            Model\ContactMethods::class => Model\ContactMethod::class,
//            Model\Products::class => Model\Product::class,
//            Model\Services::class => Model\Service::class,
//            Model\Trademarks::class => Model\Trademark::class,
//            Model\Terminals::class => Model\Trademark::class,
//        ];
//
//        return $mapping[$collectionClassName];
//    }
}
