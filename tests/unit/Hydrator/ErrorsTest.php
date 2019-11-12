<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\{
    Exception\InvalidArgumentException,
    Hydrator\Errors as ErrorsHydrator,
    Model\Errors
};
use Zend\Hydrator\HydratorInterface;
use Exception;

/**
 * Class ErrorsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class ErrorsTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new ErrorsHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldAcceptAMandateModel(): void
    {
        $hydrator = new ErrorsHydrator();
        expect($hydrator->hydrate([], new Errors()))->isInstanceOf(Errors::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new ErrorsHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new ErrorsHydrator();
        $errors = $hydrator->hydrate([
            'errors' => [
                'error_1' => 'error_message_1',
                'error_2' => 'error_message_2',
            ]
        ], new Errors());

        expect($errors->getErrors())->array();
        expect($errors->getErrors())->count(2);
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new ErrorsHydrator();
        $errors = $hydrator->hydrate([
            'errors' => [
                'error_1' => 'error_message_1',
                'error_2' => 'error_message_2',
            ]
        ], new Errors());

        $data = $hydrator->extract($errors);
        $this->assertIsArray($data);
        verify($data)->hasKey('errors');

        expect($data['errors'])->array();
        expect($data['errors'])->count(2);
    }
}
