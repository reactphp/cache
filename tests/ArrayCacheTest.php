<?php

namespace React\Tests\Cache;

use React\Cache\ArrayCache;

class ArrayCacheTest extends TestCase
{
    /**
     * @var ArrayCache
     */
    private $cache;

    /**
     * @before
     */
    public function setUpArrayCache(): void
    {
        $this->cache = new ArrayCache();
    }

    /** @test */
    public function getShouldResolvePromiseWithNullForNonExistentKey(): void
    {
        $this->cache->get('foo')->then($this->expectCallableOnceWith(null));
    }

    /** @test */
    public function setShouldSetKey(): void
    {
        $this->cache->set('foo', 'bar')->then($this->expectCallableOnceWith(true));

        $this->cache->get('foo')->then($this->expectCallableOnceWith('bar'));
    }

    /** @test */
    public function deleteShouldDeleteKey(): void
    {
        $this->cache->set('foo', 'bar');

        $this->cache->delete('foo')->then($this->expectCallableOnceWith(true));

        $this->cache->get('foo')->then($this->expectCallableOnceWith(null));
    }

    public function testGetWillResolveWithNullForCacheMiss(): void
    {
        $this->cache = new ArrayCache();

        $this->cache->get('foo')->then($this->expectCallableOnceWith(null));
    }

    public function testGetWillResolveWithDefaultValueForCacheMiss(): void
    {
        $this->cache = new ArrayCache();

        $this->cache->get('foo', 'bar')->then($this->expectCallableOnceWith('bar'));
    }

    public function testGetWillResolveWithExplicitNullValueForCacheHit(): void
    {
        $this->cache = new ArrayCache();

        $this->cache->set('foo', null);
        $this->cache->get('foo', 'bar')->then($this->expectCallableOnceWith(null));
    }

    public function testLimitSizeToZeroDoesNotStoreAnyData(): void
    {
        $this->cache = new ArrayCache(0);

        $this->cache->set('foo', 'bar');

        $this->cache->get('foo')->then($this->expectCallableOnceWith(null));
    }

    public function testLimitSizeToOneWillOnlyReturnLastWrite(): void
    {
        $this->cache = new ArrayCache(1);

        $this->cache->set('foo', '1');
        $this->cache->set('bar', '2');

        $this->cache->get('foo')->then($this->expectCallableOnceWith(null));
        $this->cache->get('bar')->then($this->expectCallableOnceWith('2'));
    }

    public function testOverwriteWithLimitedSizeWillUpdateLRUInfo(): void
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

    public function testGetWithLimitedSizeWillUpdateLRUInfo(): void
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

    public function testGetWillResolveWithValueIfItemIsNotExpired(): void
    {
        $this->cache = new ArrayCache();

        $this->cache->set('foo', '1', 10);

        $this->cache->get('foo')->then($this->expectCallableOnceWith('1'));
    }

    public function testGetWillResolveWithDefaultIfItemIsExpired(): void
    {
        $this->cache = new ArrayCache();

        $this->cache->set('foo', '1', 0);

        $this->cache->get('foo')->then($this->expectCallableOnceWith(null));
    }

    public function testSetWillOverwritOldestItemIfNoEntryIsExpired(): void
    {
        $this->cache = new ArrayCache(2);

        $this->cache->set('foo', '1', 10);
        $this->cache->set('bar', '2', 20);
        $this->cache->set('baz', '3', 30);

        $this->cache->get('foo')->then($this->expectCallableOnceWith(null));
    }

    public function testSetWillOverwriteExpiredItemIfAnyEntryIsExpired(): void
    {
        $this->cache = new ArrayCache(2);

        $this->cache->set('foo', '1', 10);
        $this->cache->set('bar', '2', 0);
        $this->cache->set('baz', '3', 30);

        $this->cache->get('foo')->then($this->expectCallableOnceWith('1'));
        $this->cache->get('bar')->then($this->expectCallableOnceWith(null));
    }

    public function testGetMultiple(): void
    {
        $this->cache = new ArrayCache();
        $this->cache->set('foo', '1');

        $this->cache
            ->getMultiple(['foo', 'bar'], 'baz')
            ->then($this->expectCallableOnceWith(['foo' => '1', 'bar' => 'baz']));
    }

    public function testSetMultiple(): void
    {
        $this->cache = new ArrayCache();
        $this->cache->setMultiple(['foo' => '1', 'bar' => '2'], 10);

        $this->cache
            ->getMultiple(['foo', 'bar'])
            ->then($this->expectCallableOnceWith(['foo' => '1', 'bar' => '2']));
    }

    public function testDeleteMultiple(): void
    {
        $this->cache = new ArrayCache();
        $this->cache->setMultiple(['foo' => 1, 'bar' => 2, 'baz' => 3]);

        $this->cache
            ->deleteMultiple(['foo', 'baz'])
            ->then($this->expectCallableOnceWith(true));

        $this->cache
            ->has('foo')
            ->then($this->expectCallableOnceWith(false));

        $this->cache
            ->has('bar')
            ->then($this->expectCallableOnceWith(true));

        $this->cache
            ->has('baz')
            ->then($this->expectCallableOnceWith(false));
    }

    public function testClearShouldClearCache(): void
    {
        $this->cache = new ArrayCache();
        $this->cache->setMultiple(['foo' => 1, 'bar' => 2, 'baz' => 3]);

        $this->cache->clear();

        $this->cache
            ->has('foo')
            ->then($this->expectCallableOnceWith(false));

        $this->cache
            ->has('bar')
            ->then($this->expectCallableOnceWith(false));

        $this->cache
            ->has('baz')
            ->then($this->expectCallableOnceWith(false));
    }

    public function hasShouldResolvePromiseForExistingKey(): void
    {
        $this->cache = new ArrayCache();
        $this->cache->set('foo', 'bar');

        $this->cache
            ->has('foo')
            ->then($this->expectCallableOnceWith(true));
    }

    public function hasShouldResolvePromiseForNonExistentKey(): void
    {
        $this->cache = new ArrayCache();
        $this->cache->set('foo', 'bar');

        $this->cache
            ->has('foo')
            ->then($this->expectCallableOnceWith(false));
    }

    public function testHasWillResolveIfItemIsNotExpired(): void
    {
        $this->cache = new ArrayCache();
        $this->cache->set('foo', '1', 10);

        $this->cache
            ->has('foo')
            ->then($this->expectCallableOnceWith(true));
    }

    public function testHasWillResolveIfItemIsExpired(): void
    {
        $this->cache = new ArrayCache();
        $this->cache->set('foo', '1', 0);

        $this->cache
            ->has('foo')
            ->then($this->expectCallableOnceWith(false));
    }

    public function testHasWillResolveForExplicitNullValue(): void
    {
        $this->cache = new ArrayCache();
        $this->cache->set('foo', null);

        $this->cache
            ->has('foo')
            ->then($this->expectCallableOnceWith(true));
    }

    public function testHasWithLimitedSizeWillUpdateLRUInfo(): void
    {
        $this->cache = new ArrayCache(2);

        $this->cache->set('foo', 1);
        $this->cache->set('bar', 2);
        $this->cache->has('foo')->then($this->expectCallableOnceWith(true));
        $this->cache->set('baz', 3);

        $this->cache->has('foo')->then($this->expectCallableOnceWith(1));
        $this->cache->has('bar')->then($this->expectCallableOnceWith(false));
        $this->cache->has('baz')->then($this->expectCallableOnceWith(3));
    }
}
