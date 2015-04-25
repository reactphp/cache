<?php

namespace React\Cache;

use React\Promise\PromiseInterface;

interface CacheInterface
{
    /**
     * @param string $key
     *
     * @return PromiseInterface
     */
    public function get($key);

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value);

    /**
     * @param string $key
     */
    public function remove($key);
}
