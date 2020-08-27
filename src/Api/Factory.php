<?php

declare(strict_types=1);

namespace PayNL\Sdk\Api;

use Psr\Container\ContainerInterface;
use PayNL\GuzzleHttp\Client as GuzzleClient;
use PayNL\Sdk\{
    AuthAdapter\AdapterInterface as AuthAdapterInterface,
    Config\Config,
    Exception\ServiceNotFoundException,
    Exception\InvalidArgumentException,
    Common\FactoryInterface,
    Service\Manager as ServiceManager
};

/**
 * Class Factory
 *
 * @package PayNL\Sdk\Api
 */
class Factory implements FactoryInterface
{
    /**
     * @inheritDoc
     *
     * @throws ServiceNotFoundException
     * @throws InvalidArgumentException
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null)
    {
        switch ($requestedName) {
            case Api::class:
                /** @var Config $options */
                $options = $container->get('config')->merge(new Config($options ?? []));

                $apiUrl = rtrim($options->get('api')->get('url', ''), '/');
                $filteredApiUrl = filter_var(
                    $apiUrl,
                    FILTER_VALIDATE_URL,
                    FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED
                );

                if (false === $filteredApiUrl || 'http' === parse_url($filteredApiUrl, PHP_URL_SCHEME)) {
                    throw new InvalidArgumentException(
                        sprintf(
                            'Invalid API URL "%s" given, make sure you use the https protocol and define a correct endpoint',
                            $apiUrl
                        )
                    );
                }

                /** @var AuthAdapterInterface $authAdapter */
                $authAdapter = $container->get('authAdapterManager')->get($options->get('authentication')->get('type', 'basic'));
                $authAdapter->setUsername($options->get('authentication')->get('username', ''))
                    ->setPassword($options->get('authentication')->get('password', ''))
                ;

                $guzzleClient = new GuzzleClient([
                    'base_uri' => $filteredApiUrl . "/v{$options->get('api')->get('version', 1)}/",
                ]);

                return new Api($authAdapter, $guzzleClient, $options->toArray());
            case Service::class:
                /** @var ServiceManager $serviceManager */
                $serviceManager = $container;
                return new Service($container->get('Api'), $serviceManager);
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
