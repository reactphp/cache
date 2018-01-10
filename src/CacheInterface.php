<?php

namespace React\Cache;

use React\Promise\PromiseInterface;

interface CacheInterface
{
    /**
     * @return PromiseInterface
     */
    public function get($key);

    /**
     * @return PromiseInterface
     */
    public function set($key, $value);

    /**
     * @return PromiseInterface
     */
    public function remove($key);
}
