<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use Psr\Container\ContainerInterface;
use PayNL\Sdk\{
    Common\FactoryInterface,
    Exception\ServiceNotFoundException,
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
     * @throws ServiceNotFoundException when the model manager is not present in the container
     *
     * @return AbstractHydrator
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null): AbstractHydrator
    {
        if (false === $container->has('modelManager')) {
            throw new ServiceNotFoundException(
                sprintf(
                    'Can not create hydrator "%s" because the service modelManager can not be found',
                    $requestedName
                )
            );
        }

        $hydrator = new $requestedName($container->get('hydratorManager'), $container->get('modelManager'));
        if ($hydrator instanceof ValidatorManagerAwareInterface &&
            true === $container->has('validatorManager')
        ) {
            $hydrator->setValidatorManager($container->get('validatorManager'));
        }
        /** @var AbstractHydrator $hydrator */
        return $hydrator;
    }
}
