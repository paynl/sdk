<?php

declare(strict_types=1);

namespace PayNL\Sdk\Api;

use PayNL\GuzzleHttp\Client as GuzzleClient;
use PayNL\Sdk\AuthAdapter\AdapterInterface as AuthAdapterInterface;
use PayNL\Sdk\Exception\ServiceNotFoundException;
use PayNL\Sdk\Common\FactoryInterface;
use Psr\Container\ContainerInterface;
use Zend\Stdlib\ArrayUtils;

/**
 * Class Factory
 *
 * @package PayNL\Sdk\Api
 */
class Factory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null)
    {
        switch ($requestedName) {
            case Api::class:

                $options = ArrayUtils::merge($container->get('config'), $options ?? []);

                /** @var AuthAdapterInterface $authAdapter */
                $authAdapter = $container->get('authAdapterManager')->get($options['authentication']['type'] ?? 'basic');
                $authAdapter->setUsername($options['authentication']['username'])
                    ->setPassword($options['authentication']['password'])
                ;

                $guzzleClient = new GuzzleClient([
                    'base_uri' => rtrim($options['api']['url'], '/') . "/v{$options['api']['version']}/",
                ]);

                return new Api($authAdapter, $guzzleClient, $options);
            case Service::class:
                return new Service($container->get('Api'), $container);
            default:
                throw new ServiceNotFoundException(
                    sprintf(
                        'Cannot find service for "%s"',
                        $requestedName
                    )
                );
        }
    }
}
