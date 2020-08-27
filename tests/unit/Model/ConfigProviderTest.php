<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ConfigProviderTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\ConfigProvider;
use PayNL\Sdk\Util\Misc;
use DirectoryIterator;
use PHPUnit\Framework\Constraint\Count;

class ConfigProviderTest extends UnitTest
{
    use ConfigProviderTestTrait;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->configProvider = new ConfigProvider();
    }

    /**
     * @return void
     */
    public function testItHasModelConfig(): void
    {
        $this->tester->assertObjectHasMethod('getModelConfig', $this->configProvider);
        $config = $this->configProvider->getModelConfig();
        verify($config)->array();
        verify($config)->notEmpty();

        $configKeys = [
            'aliases',
            'factories',
            'initializers',
            'invokables',
            'mapping',
            'services',
        ];

        $this->tester->assertArrayHasAtLeastOneOfKeys($config, $configKeys);
        $this->tester->assertArrayCanOnlyContainKeys($config, $configKeys);
    }

    /**
     * @depends testItHasModelConfig
     *
     * @return void
     */
    public function testAllModelsAreDeclared(): void
    {
        $modelNames = [];
        foreach (new DirectoryIterator(realpath(__DIR__ . '/../../../src/Model')) as $file) {
            if ('php' !== $file->getExtension() ||
                1 === preg_match('/^(Abstract)?[A-z]+(Trait|Interface)\.php$/', $file->getFilename()) ||
                true === in_array($file->getFilename(), ['ConfigProvider.php', 'Manager.php'], true)
            ) {
                continue;
            }
            $modelNames[] = ltrim(Misc::getClassNameByFile($file->getPathname()), '\\');
        }

        if (0 === count($modelNames)) {
            $this->fail('No models are available?');
        }

        $models = $this->configProvider->getModelConfig()['invokables'];

        $diff = array_diff($modelNames, $models);
        $success = (new Count(0))->evaluate($diff, '', true);
        if (false === $success) {
            $this->fail(
                sprintf(
                    'Models "%s" %s not configured',
                    implode(', ', $diff),
                    1 === count($diff) ? 'is' : 'are'
                )
            );
        }
        verify($success)->true();
    }

    /**
     * @return void
     */
    public function testItHasAHydratorCollectionMap(): void
    {
        $config = ($this->configProvider)();
        verify($config)->hasKey('hydrator_collection_map');
        verify($config['hydrator_collection_map'])->array();
        verify($config['hydrator_collection_map'])->notEmpty();
    }
}
