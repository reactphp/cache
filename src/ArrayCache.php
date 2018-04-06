<?php

namespace React\Cache;

use React\Promise;

class ArrayCache implements CacheInterface
{
    private $limit;
    private $data = array();
    private $expires = array();

    /**
     * The `ArrayCache` provides an in-memory implementation of the [`CacheInterface`](#cacheinterface).
     *
     * ```php
     * $cache = new ArrayCache();
     *
     * $cache->set('foo', 'bar');
     * ```
     *
     * Its constructor accepts an optional `?int $limit` parameter to limit the
     * maximum number of entries to store in the LRU cache. If you add more
     * entries to this instance, it will automatically take care of removing
     * the one that was least recently used (LRU).
     *
     * For example, this snippet will overwrite the first value and only store
     * the last two entries:
     *
     * ```php
     * $cache = new ArrayCache(2);
     *
     * $cache->set('foo', '1');
     * $cache->set('bar', '2');
     * $cache->set('baz', '3');
     * ```
     *
     * @param int|null $limit maximum number of entries to store in the LRU cache
     */
    public function __construct($limit = null)
    {
        $this->limit = $limit;
    }

    public function get($key, $default = null)
    {
        if (!array_key_exists($key, $this->data)) {
            return Promise\resolve($default);
        }

        if (isset($this->expires[$key]) && $this->expires[$key] < time()) {
            unset($this->data[$key], $this->expires[$key]);
            return Promise\resolve($default);
        }

        // remove and append to end of array to keep track of LRU info
        $value = $this->data[$key];
        unset($this->data[$key]);
        $this->data[$key] = $value;
        return Promise\resolve($this->data[$key]);
    }

    public function set($key, $value, $ttl = null)
    {
        $expires = null;

        if (is_int($ttl)) {
            $this->expires[$key] = time() + $ttl;
        }

        // unset before setting to ensure this entry will be added to end of array
        unset($this->data[$key]);
        $this->data[$key] = $value;

        // ensure size limit is not exceeded or remove first entry from array
        if ($this->limit !== null && count($this->data) > $this->limit) {
            reset($this->data);
            $key = key($this->data);
            unset($this->data[$key], $this->expires[$key]);
        }

        return Promise\resolve(true);
    }

    public function remove($key)
    {
        unset($this->data[$key], $this->expires[$key]);
        return Promise\resolve(true);
    }
}
