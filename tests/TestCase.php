<?php

namespace React\Tests\Cache;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @param int $amount
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function expectCallableExactly($amount)
    {
        $mock = $this->createCallableMock();
        
        $mock
            ->expects($this->exactly($amount))
            ->method('__invoke');

        return $mock;
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function createCallableMock()
    {
        return $this->getMock('React\Tests\Cache\CallableStub');
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function expectCallableOnce()
    {
        $mock = $this->createCallableMock();

        $mock
            ->expects($this->once())
            ->method('__invoke');

        return $mock;
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function expectCallableNever()
    {
        $mock = $this->createCallableMock();

        $mock
            ->expects($this->never())
            ->method('__invoke');

        return $mock;
    }
}
