<?php

namespace React\Cache;

use React\Promise\PromiseInterface;

interface CacheInterface
{
    /**
     * Retrieve an item from the cache, resolves with its value on
     * success or rejects when no item can be found.
     *
     * @param string $key
     * @return PromiseInterface
     */
    public function get($key);

    /**
     * Store an item in the cache.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value);

    /**
     * Remove an item from the cache.
     *
     * @param string $key
     * @return void
     */
    public function remove($key);
}
