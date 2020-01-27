<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use Psr\Container\ContainerInterface;
use PayNL\Sdk\{
    Common\FactoryInterface,
    Validator\ValidatorManagerAwareInterface
};

/**
 * Class Factory
 *
 * @package PayNL\Sdk\Hydrator
 */
class Factory implements FactoryInterface
{
    /**
     * @inheritDoc
     *
     * @return AbstractHydrator
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null): AbstractHydrator
    {
        $hydrator = new $requestedName($container->get('hydratorManager'), $container->get('modelManager'));
        if ($hydrator instanceof ValidatorManagerAwareInterface) {
            $hydrator->setValidatorManager($container->get('validatorManager'));
        }
        /** @var AbstractHydrator $hydrator */
        return $hydrator;
    }
}
