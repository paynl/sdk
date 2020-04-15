<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use Codeception\TestAsset\SimpleModel;
use PayNL\Sdk\Model\Error;
use PayNL\Sdk\Model\Errors;
use PayNL\Sdk\Transformer\AbstractTransformer;
use PayNL\Sdk\Transformer\Response;
use PayNL\Sdk\Transformer\TransformerInterface;
use UnitTester;

class ResponseTest extends UnitTest
{
    /**
     * @var Response
     */
    protected $transformer;

    /**
     * @var UnitTester;
     */
    protected $tester;

    /**
     * @return void
     */
    private function setModel(): void
    {
        $this->transformer->setModel($this->tester->getServiceManager()->get('modelManager')->build('simpleModel'));
    }

    public function _before()
    {
        $this->transformer = new Response($this->tester->getServiceManager());
        $this->transformer->setHydrator($this->tester->grabService('hydratorManager')->get('entity'));
    }

    /**
     * @return void
     */
    public function testItIsATransformer(): void
    {
        verify($this->transformer)->isInstanceOf(AbstractTransformer::class);
        verify($this->transformer)->isInstanceOf(TransformerInterface::class);
    }

    /**
     * @return void
     */
    public function testItGivesAnEmptyArrayWhenNoModelIsSet(): void
    {
        $json = json_encode(['corge' => 'someString']);
        $model = $this->transformer->transform($json);
        verify($model)->array();
        verify($model)->isEmpty();
    }

    /**
     * @return void
     */
    public function testTransformCanGiveErrors(): void
    {
        $this->setModel();

        $json = json_encode(
            [
                'errors' => (object)[
                    'general' => (object)[
                        'code' => 500,
                        'message' => 'Internal Server Error',
                    ]
                ]
            ]
        );

        $model = $this->transformer->transform($json);
        verify($model)->isInstanceOf(Errors::class);
        verify($model->getErrors())->array();
        verify($model->getErrors())->containsOnlyInstancesOf(Error::class);
    }

    /**
     * @return void
     */
    public function testItCanTransform(): void
    {
        $this->setModel();

        $json = json_encode(['corge' => 'someString']);
        $model = $this->transformer->transform($json);
        verify($model)->isInstanceOf(SimpleModel::class);
        verify($model->getCorge())->string();
        verify($model->getCorge())->equals('someString');
    }
}