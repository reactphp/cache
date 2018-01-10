<?php

namespace React\Tests\Cache;

use React\Cache\ArrayCache;

class ArrayCacheTest extends TestCase
{
    /**
     * @var ArrayCache
     */
    private $cache;

    public function setUp()
    {
        $this->cache = new ArrayCache();
    }

    /** @test */
    public function getShouldRejectPromiseForNonExistentKey()
    {
        $this->cache
            ->get('foo')
            ->then(
                $this->expectCallableNever(),
                $this->expectCallableOnce()
            );
    }

    /** @test */
    public function setShouldSetKey()
    {
        $setPromise = $this->cache
            ->set('foo', 'bar');

        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(true));

        $setPromise->then($mock);

        $success = $this->createCallableMock();
        $success
            ->expects($this->once())
            ->method('__invoke')
            ->with('bar');

        $this->cache
            ->get('foo')
            ->then($success);
    }

    /** @test */
    public function removeShouldRemoveKey()
    {
        $this->cache
            ->set('foo', 'bar');

        $removePromise = $this->cache
            ->remove('foo');

        $mock = $this->createCallableMock();
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo(true));

        $removePromise->then($mock);

        $this->cache
            ->get('foo')
            ->then(
                $this->expectCallableNever(),
                $this->expectCallableOnce()
            );
    }
}
