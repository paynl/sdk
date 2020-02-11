<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request;

use Psr\Container\ContainerInterface;
use PayNL\Sdk\{
    Service\AbstractPluginManager,
    Service\Manager as ServiceManager,
    Validator\ValidatorManagerAwareInterface
};

/**
 * Class Manager
 *
 * @package PayNL\Sdk\Transformer
 */
class Manager extends AbstractPluginManager
{
    /**
     * @var string
     *
     * @see AbstractPluginManager::$instanceOf
     */
    protected $instanceOf = RequestInterface::class;

    /**
     * Inject the validator manager if needed
     *
     * @inheritDoc
     */
    public function __construct($parentLocator = null, array $config = [])
    {
        $this->addInitializer([$this, 'injectValidatorManager']);
        parent::__construct($parentLocator, $config);
    }

    /**
     * @inheritDoc
     */
    public function configure(array $config): ServiceManager
    {
        $services = [];
        if (true === array_key_exists('services', $config)) {
            $services = $config['services'];
            unset($config['services']);
        }

        parent::configure($config);

        // "convert" the request to services with a initialized object
        foreach ($services as $requestName => $requestConfig) {
            $requestConfig['name'] = $requestName;
            $request = $this->build(Request::class, $requestConfig);
            $services[$requestName] = $request;
        }

        parent::configure(['services' => $services]);
        return $this;
    }

    /**
     * Set the validator manager to the request instance if its
     * validator manager aware
     *
     * @param ContainerInterface $container
     * @param RequestInterface $instance
     *
     * @return void
     */
    public function injectValidatorManager(ContainerInterface $container, RequestInterface $instance): void
    {
        if (false === ($instance instanceof ValidatorManagerAwareInterface)) {
            return;
        }

        /** @var ValidatorManagerAwareInterface $instance */
        $instance->setValidatorManager($container->get('validatorManager'));
    }
}
