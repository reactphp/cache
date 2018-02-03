<?php

namespace React\Cache;

use React\Promise\PromiseInterface;

interface CacheInterface
{
    /**
     * Retrieve an item from the cache, resolves with its value on
     * success or null when no item can be found or when an error occurs.
     *
     * @param string $key
     * @return PromiseInterface
     */
    public function get($key);

    /**
     * Store an item in the cache, returns a promise which resolves to true on success or
     * false on error.
     *
     * @param string $key
     * @param mixed $value
     * @return PromiseInterface Returns a promise which resolves to true on success of false on error
     */
    public function set($key, $value);

    /**
     * Remove an item from the cache, returns a promise which resolves to true on success or
     * false on error. When the $key isn't found in the cache it also
     * resolves true.
     *
     * @param string $key
     * @return PromiseInterface Returns a promise which resolves to true on success of false on error
     */
    public function remove($key);
}
