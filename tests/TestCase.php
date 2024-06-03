<?php

namespace React\Tests\Cache;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function expectCallableOnce(): callable
    {
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke');
        assert(is_callable($mock));

        return $mock;
    }

    /** @param mixed $argument */
    protected function expectCallableOnceWith($argument): callable
    {
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($argument);
        assert(is_callable($mock));

        return $mock;
    }

    protected function expectCallableNever(): callable
    {
        $mock = $this->createCallableMock();
        $mock->expects($this->never())->method('__invoke');
        assert(is_callable($mock));

        return $mock;
    }

    protected function createCallableMock(): MockObject
    {
        $builder = $this->getMockBuilder(\stdClass::class);
        if (method_exists($builder, 'addMethods')) {
            // PHPUnit 9+
            return $builder->addMethods(['__invoke'])->getMock();
        } else {
            // legacy PHPUnit
            return $builder->setMethods(['__invoke'])->getMock();
        }
    }
}
