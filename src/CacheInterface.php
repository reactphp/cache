<?php

namespace React\Cache;

use React\Promise\PromiseInterface;

interface CacheInterface
{
    /**
     * Retrieves an item from the cache.
     *
     * This method will resolve with the cached value on success or with the
     * given `$default` value when no item can be found or when an error occurs.
     *
     * ```php
     * $cache
     *     ->get('foo')
     *     ->then('var_dump');
     * ```
     *
     * This example fetches the value of the key `foo` and passes it to the
     * `var_dump` function. You can use any of the composition provided by
     * [promises](https://github.com/reactphp/promise).
     *
     * @param string $key
     * @param mixed  $default Default value to return for cache miss or null if not given.
     * @return PromiseInterface
     */
    public function get($key, $default = null);

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
