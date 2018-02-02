<?php

namespace React\Cache;

use Exception;
use React\Promise\PromiseInterface;

/**
 * All methods only reject with an exception when an error occurs on the underlying storage
 * layer, for example the connection with Redis dropped and cannot be recovered, or the
 * directory on the filesystem used to store cache has the wrong permissions of is full.
 */
interface CacheInterface
{
    /**
     * Fetch an item from the cache, returns a promise which resolves to the value in the
     * cache on success, resolves with null when the item cannot be found, or rejects
     * with an exception on error.
     *
     * @param string $key
     * @return PromiseInterface<mixed|null|Exception>
     */
    public function get($key);

    /**
     * Store an item in the cache, returns a promise which resolves to true on success or
     * rejects with an exception on error.
     *
     * @param string $key
     * @param mixed $value
     * @return PromiseInterface<bool|Exception>
     */
    public function set($key, $value);

    /**
     * Remove an item from the cache, returns a promise which resolves to true on success or
     * rejects with an exception on error. When the $key isn't found in the cache it also
     * resolves true.
     *
     * @param string $key
     * @return PromiseInterface<bool|Exception>
     */
    public function remove($key);
}
