<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\{
    TestAsset\InvokableObject,
    Test\Unit as UnitTest
};
use PayNL\Sdk\{
    Common\DebugAwareInterface,
    Common\DateTime,
    Hydrator\AbstractHydrator,
    Validator\ValidatorManagerAwareInterface
};
use UnitTester,
    DateTime as stdDateTime,
    TypeError,
    Error
;
use Zend\Hydrator\ClassMethods;

/**
 * Class AbstractHydratorTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class AbstractHydratorTest extends UnitTest
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var AbstractHydrator
     */
    protected $anonymousClassFromAbstract;

    /**
     * @return void
     */
    public function _before(): void
    {
        $hydratorManagerMock = $this->tester->grabMockService('hydratorManager');
        $modelManagerMock = $this->tester->grabMockService('modelManager');

        $this->anonymousClassFromAbstract = new class($hydratorManagerMock, $modelManagerMock) extends AbstractHydrator
        {
        };
    }

    /**
     * @return void
     */
    public function testItCanConstruct(): void
    {
        verify($this->anonymousClassFromAbstract)->isInstanceOf(AbstractHydrator::class);
    }

    /**
     * @return void
     */
    public function testItIsAnInstanceOfClassMethodsHydrator(): void
    {
        verify($this->anonymousClassFromAbstract)->isInstanceOf(ClassMethods::class);
    }

    /**
     * @return void
     */
    public function testItIsDebugAware(): void
    {
        verify($this->anonymousClassFromAbstract)->isInstanceOf(DebugAwareInterface::class);
    }

    /**
     * @return void
     */
    public function testItIsValidatorManagerAware(): void
    {
        verify($this->anonymousClassFromAbstract)->isInstanceOf(ValidatorManagerAwareInterface::class);
    }

    /**
     * @return void
     */
    public function testItDoesNotConvertKeysToSnake_case(): void
    {
        verify($this->anonymousClassFromAbstract->getUnderscoreSeparatedKeys())->equals(false);
    }

    /**
     * @return void
     */
    public function testItAlwaysChecksTheGetAndSetMethodsExist(): void
    {
        verify($this->anonymousClassFromAbstract->getMethodExistsCheck())->equals(true);
    }

    /**
     * @return void
     */
    public function testItCanHydrate(): void
    {
        $this->tester->assertClassHasMethod('hydrate', AbstractHydrator::class);

        $data = [
            'foo' => 'bar',
            'options' => null,
        ];

        /** @var InvokableObject $object */
        $object = $this->tester->getServiceManager()->get('simpleManager')->build('foo');

        $object = $this->anonymousClassFromAbstract->hydrate($data, $object);

        $foo = $object->getFoo();
        verify($foo)->string();
        verify($foo)->notEmpty();
        verify($foo)->equals('bar');

        $options = $object->getOptions();
        verify($options)->array();
        verify($options)->isEmpty();

        $data = [
            'foo' => null,
            'options' => [
                'bar' => 'baz',
            ],
        ];

        /** @var InvokableObject $object */
        $object = $this->tester->getServiceManager()->get('simpleManager')->build('foo');

        $object = $this->anonymousClassFromAbstract->hydrate($data, $object);

        $foo = $object->getFoo();
        verify($foo)->string();
        verify($foo)->isEmpty();

        // options does not have a set method, so the array is still empty. No Exception is given
        $options = $object->getOptions();
        verify($options)->array();
        verify($options)->count(0);
    }

    /**
     * @return void
     */
    public function testItCanConvertToSdkDateTime(): void
    {
        $this->tester->assertObjectHasMethod('getSdkDateTime', $this->anonymousClassFromAbstract);
        $this->tester->assertObjectMethodIsProtected('getSdkDateTime', $this->anonymousClassFromAbstract);

        $dtString = '2020-03-11 13:39:40';
        $format   = 'Y-m-d H:i:s';

        $dateTime = DateTime::createFromFormat($format, $dtString);
        $output = $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'getSdkDateTime', [$dateTime]);
        verify($output)->isInstanceOf(DateTime::class);
        verify($output)->same($dateTime);
        verify($output->format($format))->equals($dtString);


        $dateTime = stdDateTime::createFromFormat($format, $dtString);
        $output = $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'getSdkDateTime', [$dateTime]);
        verify($output)->isInstanceOf(DateTime::class);
        verify($output)->notSame($dateTime);
        verify($output->format($format))->equals($dtString);

        $dateTime = '2020-03-11T13:39:40+0100';
        $output = $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'getSdkDateTime', [$dateTime]);
        verify($output)->isInstanceOf(DateTime::class);
        verify($output->format($format))->equals($dtString);

        $dateTime = '';
        $output = $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'getSdkDateTime', [$dateTime]);
        verify($output)->null();
    }

    /**
     * @return void
     */
    public function testGetSdkDateTimeThrowsATypeErrorWithInvalidInput(): void
    {
        $this->expectException(TypeError::class);
        $this->tester->invokeMethod($this->anonymousClassFromAbstract, 'getSdkDateTime', [true]);
    }

    /**
     * @return void
     */
    public function testGetSdkDateTimeThrowsAnErrorWithInvalidInput(): void
    {
        verify($this->tester->invokeMethod(
            $this->anonymousClassFromAbstract,
            'getSdkDateTime',
            ['2020-03-11T13:39:40']
        ))->null();
    }
}
