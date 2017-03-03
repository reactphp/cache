<?php

namespace React\Cache;

use React\Promise\PromiseInterface;

interface CacheInterface
{
    /**
     * @param $key
     * @return PromiseInterface
     */
    public function get($key);

    /**
     * @param $key
     * @param $value
     * @return PromiseInterface
     */
    public function set($key, $value);

    /**
     * @param $key
     * @return PromiseInterface
     */
    public function remove($key);
}
