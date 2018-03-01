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
    public function getShouldResolvePromiseWithNullForNonExistentKey()
    {
        $success = $this->createCallableMock();
        $success
            ->expects($this->once())
            ->method('__invoke')
            ->with(null);

        $this->cache
            ->get('foo')
            ->then(
                $success,
                $this->expectCallableNever()
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
                $this->expectCallableOnce(),
                $this->expectCallableNever()
            );
    }

    public function testLimitSizeToZeroDoesNotStoreAnyData()
    {
        $this->cache = new ArrayCache(0);

        $this->cache->set('foo', 'bar');

        $this->cache->get('foo')->then($this->expectCallableOnceWith(null));
    }

    public function testLimitSizeToOneWillOnlyReturnLastWrite()
    {
        $this->cache = new ArrayCache(1);

        $this->cache->set('foo', '1');
        $this->cache->set('bar', '2');

        $this->cache->get('foo')->then($this->expectCallableOnceWith(null));
        $this->cache->get('bar')->then($this->expectCallableOnceWith('2'));
    }

    public function testOverwriteWithLimitedSizeWillUpdateLRUInfo()
    {
        $this->cache = new ArrayCache(2);

        $this->cache->set('foo', '1');
        $this->cache->set('bar', '2');
        $this->cache->set('foo', '3');
        $this->cache->set('baz', '4');

        $this->cache->get('foo')->then($this->expectCallableOnceWith('3'));
        $this->cache->get('bar')->then($this->expectCallableOnceWith(null));
        $this->cache->get('baz')->then($this->expectCallableOnceWith('4'));
    }

    public function testGetWithLimitedSizeWillUpdateLRUInfo()
    {
        $this->cache = new ArrayCache(2);

        $this->cache->set('foo', '1');
        $this->cache->set('bar', '2');
        $this->cache->get('foo')->then($this->expectCallableOnceWith('1'));
        $this->cache->set('baz', '3');

        $this->cache->get('foo')->then($this->expectCallableOnceWith('1'));
        $this->cache->get('bar')->then($this->expectCallableOnceWith(null));
        $this->cache->get('baz')->then($this->expectCallableOnceWith('3'));
    }
}
