<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Codeception\{Test\Unit as UnitTest,
    TestAsset\ComplexModel,
    TestAsset\SimpleDateTime,
    TestAsset\SimpleCollection,
    TestAsset\SimpleDependencyObject,
    TestAsset\SimpleModel};
use PayNL\Sdk\{
    Exception\LogicException,
    Exception\RuntimeException,
    Hydrator\Entity,
    Model\Manager,
    Model\Links
};
use UnitTester,
    ReflectionClass,
    ReflectionException,
    ReflectionProperty,
    DateTime,
    stdClass
;

/**
 * Class EntityTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class EntityTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var Manager
     */
    protected $modelManager;

    /**
     * @var Entity
     */
    protected $hydrator;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->modelManager = $this->tester->grabService('modelManager');

        $hydratorManager = $this->tester->grabService('hydratorManager');

        $this->hydrator = new Entity($hydratorManager, $this->modelManager);
        $this->hydrator->setOptions([
            'collectionMap' => $this->tester->grabService('config')->get('hydrator_collection_map')->toArray()
        ]);
    }

    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanLoadModelInfoBasedOnAnnotations(): void
    {
        /** @var ComplexModel $modelToHydrate */
        $modelToHydrate = $this->modelManager->get('complexModel');
        $propertyInfo = $this->tester->invokeMethod($this->hydrator, 'load', [$modelToHydrate]);

        $ref = new ReflectionClass($modelToHydrate);
        $shouldContainProperties = array_map(static function (ReflectionProperty $property) {
            return $property->getName();
        }, $ref->getProperties());

        verify($propertyInfo)->array();
        verify(array_keys($propertyInfo))->equals(array_values($shouldContainProperties));
    }

    /**
     * @return void
     */
    public function testLoadThrowsExceptionWhenPropertyDoesNotHaveDocBlock(): void
    {
        $this->expectException(LogicException::class);
        $this->tester->invokeMethod($this->hydrator, 'load', [$this->modelManager->get('failingModel')]);
    }

    /**
     * @return void
     */
    public function testLoadThrowsExceptionWhenPropertyDoesNotHaveVarDeclaration(): void
    {
        $this->expectException(LogicException::class);
        $this->tester->invokeMethod($this->hydrator, 'load', [$this->modelManager->get('secondFailingModel')]);
    }

    /**
     * @return void
     */
    public function testItCanHydrate(): void
    {
        $data = [
            'foo' => 'bar',
            'bar' => [
                'qux' => 'quux',
            ],
            'baz' => SimpleDateTime::now(),
            'corge' => [
                'simpleModels' => [[
                    'corge' => 'grault',
                ], [
                    'corge' => 'garply',
                ]],
            ],
            '_links' => [[
                'rel' => 'self',
                'type' => 'url',
                'url' => 'http://foo.bar.baz',
            ]],
        ];

        $model = $this->hydrator->hydrate($data, $this->modelManager->build('complexModel'));
        verify($model)->isInstanceOf(ComplexModel::class);
        verify($model->getFoo())->string();
        verify($model->getFoo())->notEmpty();
        verify($model->getFoo())->equals('bar');
        verify($model->getBaz())->isInstanceOf(DateTime::class);
        verify($model->getCorge())->isInstanceOf(SimpleCollection::class);
        verify($model->getCorge())->count(2);
        verify($model->getCorge())->containsOnlyInstancesOf(SimpleModel::class);
        verify($model->getLinks())->isInstanceOf(Links::class);
        verify($model->getLinks())->count(1);
    }

    /**
     * @return void
     */
    public function testHydrateThrowsAnExceptionWithWrongModelInstance(): void
    {
        $this->expectException(RuntimeException::class);
        $this->hydrator->hydrate([], new stdClass());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testItCanExtract(): void
    {
        /** @var ComplexModel $complexModel */
        $complexModel = $this->modelManager->get('complexModel');

        $simpleCollection = new SimpleCollection();
        $simpleCollection->addSimpleModel((new SimpleModel())->setCorge('garply'));
        $simpleCollection->add('grault');

        $arrayCollection = new ArrayCollection();
        $arrayCollection->set('garply', 'waldo');

        $complexModel->setFoo('bar')
            ->setBar((new SimpleDependencyObject())
                 ->setQux('quux')
            )
            ->setBaz(SimpleDateTime::now())
            ->setCorge($simpleCollection)
            ->setArrayCollection($arrayCollection)
        ;


        $data = $this->hydrator->extract($complexModel);

        verify($data)->array();
        verify($data)->hasKey('foo');
        verify($data['foo'])->string();
        verify($data['foo'])->equals('bar');
        verify($data)->hasKey('bar');
        verify($data['bar'])->array();
        verify($data['bar'])->hasKey('qux');
        verify($data['bar']['qux'])->string();
        verify($data['bar']['qux'])->equals('quux');
        verify($data)->hasKey('baz');
        verify($data['baz'])->string();
        verify($data['baz'])->notEmpty();
        verify($data)->hasKey('corge');
        verify($data['corge'])->array();
        verify($data['corge'])->hasKey('simpleModels');
        verify($data['corge']['simpleModels'])->array();
        verify($data['corge']['simpleModels'])->count(2);
        verify($data['arrayCollection'])->array();
        verify($data['arrayCollection'])->count(1);
        verify($data['arrayCollection'])->hasKey('garply');
        verify($data['arrayCollection']['garply'])->string();
        verify($data['arrayCollection']['garply'])->equals('waldo');
    }
}
