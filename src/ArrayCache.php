<?php

namespace React\Cache;

use React\Promise;

class ArrayCache implements CacheInterface
{
    private $data = array();

    public function get($key)
    {
        if (!isset($this->data[$key])) {
            return Promise\reject();
        }

        return Promise\resolve($this->data[$key]);
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
        return new Promise\FulfilledPromise(true);
    }

    public function remove($key)
    {
        unset($this->data[$key]);
        return new Promise\FulfilledPromise(true);
    }
}
