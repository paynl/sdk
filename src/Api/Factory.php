<?php

declare(strict_types=1);

namespace PayNL\Sdk\Api;

use PayNL\GuzzleHttp\Client as GuzzleClient;
use PayNL\Sdk\AuthAdapter\AdapterInterface as AuthAdapterInterface;
use PayNL\Sdk\Config\Config;
use PayNL\Sdk\Exception\ServiceNotFoundException;
use PayNL\Sdk\Common\FactoryInterface;
use PayNL\Sdk\Service\Manager;
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
                /** @var Config $options */
                $options = $container->get('config')->merge(new Config($options ?? []));

                /** @var AuthAdapterInterface $authAdapter */
                $authAdapter = $container->get('authAdapterManager')->get($options->get('authentication')->get('type', 'basic'));
                $authAdapter->setUsername($options->get('authentication')->get('username', ''))
                    ->setPassword($options->get('authentication')->get('password', ''))
                ;

                $guzzleClient = new GuzzleClient([
                    'base_uri' => rtrim($options->get('api')->get('url', ''), '/') . "/v{$options->get('api')->get('version', 1)}/",
                ]);

                return new Api($authAdapter, $guzzleClient, $options->toArray());
            case Service::class:
                /** @var Manager $container */
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
