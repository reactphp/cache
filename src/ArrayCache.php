<?php

namespace React\Cache;

use React\Promise;
use React\Promise\PromiseInterface;

class ArrayCache implements CacheInterface
{
    private $data = array();

    /**
     * @param $key
     * @return PromiseInterface
     */
    public function get($key)
    {
        if (!isset($this->data[$key])) {
            return Promise\reject();
        }

        return Promise\resolve($this->data[$key]);
    }

    /**
     * @param $key
     * @param $value
     * @return PromiseInterface
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
        return new Promise\FulfilledPromise(true);
    }

    /**
     * @param $key
     * @return PromiseInterface
     */
    public function remove($key)
    {
        unset($this->data[$key]);
        return new Promise\FulfilledPromise(true);
    }
}
