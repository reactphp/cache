<?php

namespace React\Tests\Cache;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function expectCallableExactly($amount)
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->exactly($amount))
            ->method('__invoke');

        return $mock;
    }

    protected function expectCallableOnce()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke');

        return $mock;
    }

    protected function expectCallableOnceWith($param)
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($param);

        return $mock;
    }

    protected function expectCallableNever()
    {
        $mock = $this->createCallableMock();
        $mock
            ->expects($this->never())
            ->method('__invoke');

        return $mock;
    }

    protected function createCallableMock()
    {
        return $this->getMockBuilder('React\Tests\Cache\CallableStub')->getMock();
    }
}
