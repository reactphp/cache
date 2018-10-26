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
     * Similarly, an expired cache item (once the time-to-live is expired) is
     * considered a cache miss.
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
     * Stores an item in the cache.
     *
     * This method will resolve with `true` on success or `false` when an error
     * occurs. If the cache implementation has to go over the network to store
     * it, it may take a while.
     *
     * The optional `$ttl` parameter sets the maximum time-to-live in seconds
     * for this cache item. If this parameter is omitted (or `null`), the item
     * will stay in the cache for as long as the underlying implementation
     * supports. Trying to access an expired cache item results in a cache miss,
     * see also [`get()`](#get).
     *
     * ```php
     * $cache->set('foo', 'bar', 60);
     * ```
     *
     * This example eventually sets the value of the key `foo` to `bar`. If it
     * already exists, it is overridden.
     *
     * @param string $key
     * @param mixed  $value
     * @param ?float $ttl
     * @return PromiseInterface Returns a promise which resolves to `true` on success or `false` on error
     */
    public function set($key, $value, $ttl = null);

    /**
     * Deletes an item from the cache.
     *
     * This method will resolve with `true` on success or `false` when an error
     * occurs. When no item for `$key` is found in the cache, it also resolves
     * to `true`. If the cache implementation has to go over the network to
     * delete it, it may take a while.
     *
     * ```php
     * $cache->delete('foo');
     * ```
     *
     * This example eventually deletes the key `foo` from the cache. As with
     * `set()`, this may not happen instantly and a promise is returned to
     * provide guarantees whether or not the item has been removed from cache.
     *
     * @param string $key
     * @return PromiseInterface Returns a promise which resolves to `true` on success or `false` on error
     */
    public function delete($key);

    /**
     * Retrieves multiple cache items by their unique keys.
     *
     * This method will resolve with the list of cached value on success or with the
     * given `$default` value when no item can be found or when an error occurs.
     * Similarly, an expired cache item (once the time-to-live is expired) is
     * considered a cache miss.
     *
     * ```php
     * $cache
     *     ->getMultiple(array('foo', 'bar'))
     *     ->then('var_dump');
     * ```
     *
     * This example fetches the list of value for `foo` and `bar` keys and passes it to the
     * `var_dump` function. You can use any of the composition provided by
     * [promises](https://github.com/reactphp/promise).
     *
     * @param iterable $keys    A list of keys that can obtained in a single operation.
     * @param mixed    $default Default value to return for keys that do not exist.
     * @return PromiseInterface
     */
    public function getMultiple($keys, $default = null);

    /**
     * Persists a set of key => value pairs in the cache, with an optional TTL.
     *
     * This method will resolve with `true` on success or `false` when an error
     * occurs. If the cache implementation has to go over the network to store
     * it, it may take a while.
     *
     * The optional `$ttl` parameter sets the maximum time-to-live in seconds
     * for these cache items. If this parameter is omitted (or `null`), these items
     * will stay in the cache for as long as the underlying implementation
     * supports. Trying to access an expired cache items results in a cache miss,
     * see also [`get()`](#get).
     *
     * ```php
     * $cache->setMultiple(array('foo' => 1, 'bar' => 2), 60);
     * ```
     *
     * This example eventually sets the list of values - the key `foo` to 1 value
     * and the key `bar` to 2. If some of the keys already exist, they are overridden.
     *
     * @param iterable $values A list of key => value pairs for a multiple-set operation.
     * @param ?float   $ttl    Optional. The TTL value of this item.
     * @return bool PromiseInterface Returns a promise which resolves to `true` on success or `false` on error
     */
    public function setMultiple($values, $ttl = null);
}
